<?php

namespace App\Http\Controllers\Admin;

use App\Models\Address;
use App\Models\Category;
use App\Models\Media;
use App\Models\StorageType;
use App\Models\Store;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Services\TranslationService;
use App\Traits\HandlesValidation;
use App\Services\StoreService;
use App\Services\MediaService;
use App\Services\WalletService;

class UserController extends Controller
{
    use HandlesValidation;
    public function login()
    {
        return view('admin/pages/forms/aurora-login');
    }
    public function seller_login()
    {
        return view('seller/pages/forms/login');
    }
    public function delivery_boy_login()
    {
        return view('delivery_boy/pages/forms/login');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login')->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function seller_logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/seller/login')->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
    public function delivery_boy_logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/delivery_boy/login')->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'password' => 'required',
            'mobile' => 'required',
        ]);

        // Normalize mobile number - handle Congolese formats:
        // +243976543210 → 976543210
        // 0976543210 → 976543210
        // 976543210 → 976543210
        $mobile = $request->input('mobile');
        $mobile = preg_replace('/[^0-9]/', '', $mobile);
        
        // Remove country code prefix if present
        if (str_starts_with($mobile, '243') && strlen($mobile) > 9) {
            $mobile = substr($mobile, 3);
        }
        
        // Remove leading 0 for local format
        if (str_starts_with($mobile, '0')) {
            $mobile = substr($mobile, 1);
        }

        $formFields['mobile'] = $mobile;
        $formFields['country_code'] = '243';

        // Find user manually — handles +243 or 243 prefix in DB
        $user = User::where('mobile', $mobile)
            ->where(function ($q) {
                $q->where('country_code', '243')
                  ->orWhere('country_code', '+243');
            })
            ->where('active', 1)
            ->first();

        \Illuminate\Support\Facades\Log::info('AUTH_DEBUG user lookup', [
            'user_found' => $user ? true : false,
            'user_id' => $user ? $user->id : null,
            'user_role_id' => $user ? $user->role_id : null,
            'user_role' => $user ? $user->role : null,
            'hash_check' => $user ? Hash::check($formFields['password'], $user->password) : false,
        ]);

        if ($user && Hash::check($formFields['password'], $user->password)) {
            auth()->login($user);

            // Reload user fresh from DB (avoid stale session data)
            $user = User::with('role')->find($user->id);

            if ($user) {

                // Use Spatie roles if available, fallback to role->name
                $roleName = null;
                if ($user->role) {
                    $roleName = $user->role->name;
                } elseif (method_exists($user, 'getRoleNames')) {
                    $roleNames = $user->getRoleNames();
                    $roleName = $roleNames->first();
                }

                if ($roleName == 'delivery_boy') {
                    if ($user->status != 1) {
                        return response()->json([
                            'errors' => [
                                'status' => ['Your account is not active. Please contact super admin.']
                            ]
                        ], 422);
                    }
                    return response()->json([
                        'message' => 'Login successful',
                        'location' => '/delivery_boy/home'
                    ]);
                }

                if ($roleName == 'affiliate') {
                    $affiliate = $user->affiliateUser;

                    if (!$affiliate) {
                        return response()->json([
                            'errors' => [
                                'status' => ['Affiliate account not found. Please contact support.']
                            ]
                        ], 422);
                    }

                    if ($affiliate->status == 2) {
                        return response()->json([
                            'errors' => [
                                'status' => ['Your affiliate account is pending approval.']
                            ]
                        ], 422);
                    }

                    if ($affiliate->status == 0) {
                        return response()->json([
                            'errors' => [
                                'status' => ['Your affiliate account has been rejected.']
                            ]
                        ], 422);
                    }

                    return response()->json([
                        'message' => 'Login successful',
                        'location' => '/affiliate/home'
                    ]);
                }

                if ($roleName == 'seller') {
                    return response()->json([
                        'message' => 'Login successful',
                        'location' => '/seller/home'
                    ]);
                }

                if (in_array($roleName, ['super_admin', 'admin', 'editor'])) {
                    return response()->json([
                        'message' => 'Connexion réussie. Bienvenue sur Aurora.',
                        'location' => '/admin/home'
                    ]);
                }

                return response()->json([
                    'errors' => [
                        'role' => ['You do not have access to this panel']
                    ]
                ], 422);
            } else {
                return response()->json([
                    'errors' => [
                        'account' => ['Your account is not activated yet. Please wait for activation.']
                    ]
                ], 422);
            }
        }

        return response()->json([
            'errors' => [
                'email' => ['Invalid credentials']
            ]
        ], 422);
    }



    public function edit(User $user)
    {
        return view('admin.pages.forms.account', ['user' => $user]);
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'username' => ['required'],
            'email' => ['required'],
            'mobile' => 'required',
        ];
        if (!empty($request->input('old_password')) || !empty($request->input('new_password'))) {
            $rules['old_password'] = 'required';
            $rules['new_password'] = ['required', 'confirmed'];
            $rules['image'] = 'image|mimes:jpeg,gif,jpg,png,webp';
        }

        $user = User::find($id);

        // Check if the old password matches the one in the database
        if (!empty($request->input('old_password'))) {
            if (!Hash::check($request->old_password, $user->password)) {
                if ($request->ajax()) {
                    return response()->json([
                        'message' => labels('admin_labels.incorrect_old_password', 'The old password is incorrect.')
                    ], 422);
                }
                return redirect()->back()->withErrors([
                    'old_password' => labels('admin_labels.incorrect_old_password', 'The old password is incorrect.')
                ])->withInput();
            }
        }

        $userImgPath = public_path(config('constants.USER_IMG_PATH'));

        if (!File::exists($userImgPath)) {
            File::makeDirectory($userImgPath, 0755, true);
        }

        if ($response = $this->HandlesValidation($request, $rules)) {
            return $response;
        }

        //----------------- image upload code ----------------------------
        $image = $user->image; // keep existing by default
        try {
            if ($request->hasFile('image')) {
                // Delete old image file if it exists and is local
                if (!empty($user->image) && $user->disk != 's3') {
                    $oldPath = public_path(config('constants.USER_IMG_PATH') . '/' . $user->image);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }

                $mediaFile = $request->file('image');
                $extension = $mediaFile->getClientOriginalExtension();

                // Create a unique filename
                $uniqueId = time() . '_' . mt_rand(1000, 9999);
                $sanitizedFileName = strtolower(str_replace(['#', '/', '\\', ' '], '-', $mediaFile->getClientOriginalName()));
                $baseName = pathinfo($sanitizedFileName, PATHINFO_FILENAME);
                $newFileName = "{$baseName}-{$uniqueId}.{$extension}";

                // Store directly to storage/app/public/user_image/
                $mediaFile->storeAs('user_image', $newFileName, 'public');

                $image = $newFileName;
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }

        // Update the user's other details
        $formFields = [
            'username' => $request->username,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'country_code' => $request->filled('country_code') ? $request->country_code : $user->country_code,
            'address' => $request->address,
            'image' => $image,
            'disk' => 'public',
        ];
        $user->update($formFields);

        // // Update the password if a new password is provided
        // if ($request->new_password) {
        //     $user->password = Hash::make($request->new_password);
        //     $user->save();
        // }

        // if ($request->ajax()) {
        //     return response()->json(['message' => labels('admin_labels.profile_details_updated_successfully', 'Profile details updated successfully!')]);
        // }

        // return back()->with('message', labels('admin_labels.profile_details_updated_successfully', 'Profile details updated successfully!'));

        // Update the password if a new password is provided
        if ($request->new_password) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            // Logout user after password change
            Auth::logout();

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Password changed successfully. Please login again.',
                    'redirect' => route('login') // or route('admin.login')
                ]);
            }

            return redirect()->route('login')->with('message', 'Password changed successfully. Please login again.');
        }

        // 👉 If password NOT changed → continue normal flow
        if ($request->ajax()) {
            return response()->json([
                'message' => labels('admin_labels.profile_details_updated_successfully', 'Profile details updated successfully!')
            ]);
        }

        return back()->with('message', labels('admin_labels.profile_details_updated_successfully', 'Profile details updated successfully!'));
    }


    public function updatePhoto(Request $request, $id)
    {

        if ($request->hasFile('upload')) {
            $formFields['photo'] = $request->file('upload')->store('photos', 'public');
            User::find($id)->update($formFields);
            session()->flash('success', 'Image Upload successfully');
            return back()->with('message', labels('admin_labels.profile_picture_updated_successfully', 'Profile picture update Successfully!'));
        }
    }
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return response()->json([
                'error' => false,
                'message' => labels('admin_labels.user_deleted_successfully', 'User deleted successfully!')
            ]);
        } else {
            return response()->json(['error' => labels('admin_labels.data_not_found', 'Data Not Found')]);
        }
    }


    public function store(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
            'password' => 'required|confirmed|min:6'
        ]);
        if ($validator->fails()) {
            // Return the validation errors as a JSON response
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $formFields['first_name'] = $request->first_name;
        $formFields['last_name'] = $request->last_name;
        $formFields['email'] = $request->email;
        $formFields['password'] = bcrypt($request->password);
        $formFields['photo'] = "photos/no-image.png";
        $formFields['role_id'] = 2;
        $formFields['status'] = 1;

        $user = User::create($formFields);

        auth()->login($user);

        if ($request->ajax()) {
            return response()->json(['message' => labels('admin_labels.registered_successfully', 'Registered Successfully!')]);
        } else {
            return redirect('/login')->with('message', labels('admin_labels.registered_successfully', 'Registered Successfully!'));
        }
    }

    public function searchUser(Request $request)
    {
        $search_term = trim($request->input('search'));

        $users = User::select('id', 'username', 'email', 'mobile', 'active')
            ->where(function ($query) use ($search_term) {
                $query->where('username', 'like', '%' . $search_term . '%')
                    ->orWhere('email', 'like', '%' . $search_term . '%')
                    ->orWhere('mobile', 'like', '%' . $search_term . '%');
            })
            ->where('active', '1')
            ->where('role_id', '!=', '4')
            ->get();

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                "id" => $user->id,
                "text" => $user->username . ' (' . $user->email . ' - ' . $user->mobile . ')',
            ];
        }

        return response()->json($data);
    }
    public function searchSeller(Request $request)
    {
        $search_term = trim($request->input('search'));

        $users = User::select('users.id', 'users.username')
            ->join('seller_data', 'seller_data.user_id', '=', 'users.id')
            ->where('users.username', 'like', '%' . $search_term . '%')
            ->where('users.active', '1')
            ->where('users.role_id', '4')
            ->where('seller_data.status', '1')
            ->get();

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                "id" => $user->id,
                "text" => $user->username,
            ];
        }

        return response()->json($data);
    }
    public function customers()
    {
        $customers = User::where('role_id', 2)->get();

        return view('admin.pages.tables.customers', ['customers' => $customers]);
    }

    public function getCustomersList()
    {
        $search = trim(request('search'));
        $offset = request('offset', 0);
        $limit = request('limit', 10);
        $sort = request('sort', 'id');
        $order = request('order', 'asc');
        $status = request('status', '');
        $allowModification = config('constants.ALLOW_MODIFICATION') == 1;
        // dd($status);
        $query = User::where('role_id', 2);

        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('id', $search)
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('mobile', 'like', '%' . $search . '%');
            });
        }

        if ($status != "") {
            $query->where('active', $status);
        }


        $total = $query->count();


        $customers = $query->orderBy($sort, $order)->offset($offset)
            ->limit($limit)
            ->get();

        $bulkData = [];
        $bulkData['total'] = $total;
        $rows = [];

        foreach ($customers as $row) {
            $viewOrderUrl = route('admin.orders.index', ['user_id' => $row->id]);
            $viewTransactionUrl = route('admin.customers.viewTransactions', ['user_id' => $row->id]);

            $delete_url = route('customers.destroy', $row->id);

            $action = '<div class="dropdown bootstrap-table-dropdown">
                <a href="#" class="text-dark" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-dots-horizontal-rounded"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item dropdown_menu_items" href="' . $viewOrderUrl . '"><i class="bx bxs-show mx-2"></i> ' . labels('admin_labels.view_orders', 'View Orders') . '</a>
                <a class="dropdown-item dropdown_menu_items" href="' . $viewTransactionUrl . '"><i class="bx bxs-show mx-2"></i> ' . labels('admin_labels.view_transaction', 'View Transaction') . '</a>
                <a class="dropdown-item dropdown_menu_items" href="" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#customer-address-modal"><i class="bx bxs-show mx-2"></i> ' . labels('admin_labels.view_address', 'View Address') . '</a>
                <a class="dropdown-item delete-data dropdown_menu_items" data-url="' . $delete_url . '"><i class="bx bx-trash mx-2"></i> ' . labels('admin_labels.delete', 'Delete') . '</a>
                </div>
            </div>';

            $rows[] = [
                'id' => $row->id,
                'name' => $row->username,
                'email' => $allowModification ? $row->email : '************',
                'mobile' => $allowModification ? $row->mobile : '************',
                'balance' => $row->balance,
                'operate' => $action,
                'status' => '<select class="form-select status_dropdown change_toggle_status ' . ($row->active == 1 ? 'active_status' : 'inactive_status') . '" data-id="' . $row->id . '" data-url="/admin/customers/update_status/' . $row->id . '" aria-label="">
                  <option value="1" ' . ($row->active == 1 ? 'selected' : '') . '>' . labels('admin_labels.active', 'Active') . '</option>
                  <option value="0" ' . ($row->active == 0 ? 'selected' : '') . '>' . labels('admin_labels.deactive', 'Deactive') . '</option>
              </select>',

            ];
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }
    public function update_status($id)
    {
        $user = User::findOrFail($id);
        $user->active = $user->active == '1' ? '0' : '1';

        $user->save();
        return response()->json(['success' => labels('admin_labels.status_updated_successfully', 'Status updated successfully.')]);
    }

    public function getCustomersAddresses(Request $request)
    {
        $view_id = $request['user_id'];
        return view('admin.pages.tables.manage_address', compact('view_id'));
    }

    public function getCustomersAddressesList($user_id = '')
    {
        $offset = request()->input('search') || request('pagination_offset') ? request('pagination_offset') : 0;
        $limit = request()->input('limit', 10);
        $sort = request()->input('sort', 'id');
        $order = request()->input('order', 'ASC');
        $search = trim(request()->input('search', ''));
        $allowModification = config('constants.ALLOW_MODIFICATION') == 1;
        $user_id = $user_id ?: request()->input('user_id');

        // Start Eloquent query
        $query = Address::query();

        if (!empty($user_id)) {
            $query->where('user_id', $user_id);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->orWhere('name', 'like', "%$search%")
                    ->orWhere('address', 'like', "%$search%")
                    ->orWhere('mobile', 'like', "%$search%")
                    ->orWhere('area', 'like', "%$search%")
                    ->orWhere('city', 'like', "%$search%")
                    ->orWhere('state', 'like', "%$search%")
                    ->orWhere('country', 'like', "%$search%")
                    ->orWhere('pincode', 'like', "%$search%");
            });
        }

        $total = $query->count();

        $addresses = $query->orderBy($sort, $order)
            ->offset($offset)
            ->limit($limit)
            ->get();

        $rows = $addresses->map(function ($row) use ($allowModification) {
            return [
                'id' => $row->id,
                'name' => $row->name,
                'type' => $row->type,
                'mobile' => $allowModification ? $row->mobile : '************',
                'alternate_mobile' => $allowModification ? $row->alternate_mobile : '************',
                'address' => $row->address,
                'landmark' => $row->landmark,
                'area' => $row->area,
                'area_id' => $row->area_id,
                'city' => $row->city,
                'city_id' => $row->city_id,
                'state' => $row->state,
                'pincode' => $row->pincode,
                'system_pincode' => $row->system_pincode,
                'pincode_name' => $row->pincode,
                'country' => $row->country,
            ];
        });

        return response()->json([
            'total' => $total,
            'rows' => $rows,
        ]);
    }

    public function viewTransactions(Request $request)
    {
        $user_id = $request['user_id'];
        return view('admin.pages.tables.manage_transactions', compact('user_id'));
    }

    public function walletTransaction()
    {
        return view('admin.pages.tables.manage_customer_wallet');
    }

    public function getTransactionList(SellerController $sellerController)
    {
        $res = $sellerController->wallet_transactions_list();
        return $res;
    }

    public function updateCustomerWallet(Request $request)
    {

        $rules = [
            'user_id' => 'required|exists:users,id',
            'type' => 'required',
            'amount' => 'required|numeric',
            'message' => 'required'
        ];

        if ($response = $this->HandlesValidation($request, $rules)) {
            return $response;
        }
        if ($request['type'] == 'debit' || $request['type'] == 'credit') {
            $message = (isset($request['message']) && !empty($request['message'])) ? $request['message'] : "Balance " . $request['type'] . "ed.";
            $response = app(WalletService::class)->updateWalletBalance($request['type'], $request['user_id'], $request['amount'], $message);

            return response()->json($response);
        }
    }

    public function getCategories(
        $id = null,
        $limit = null,
        $offset = null,
        $sort = 'row_order',
        $order = 'ASC',
        $has_child_or_item = 'true',
        $slug = '',
        $ignore_status = '',
        $seller_id = '',
        $store_id = '',
        $language_code = ""
    ) {
        $level = 0;

        $storeId = app(StoreService::class)->getStoreId();

        $query = Category::query();

        // Apply store filters
        if (!empty($storeId)) {
            $query->where('store_id', $storeId);
        }
        if (!empty($store_id)) {
            $query->where('store_id', $store_id);
        }

        // Filter by ID
        if (!empty($id)) {
            $query->where('id', $id);
            if ($ignore_status != 1) {
                $query->where('status', 1);
            }
        } else {
            if ($ignore_status != 1) {
                $query->where('status', 1);
            }
        }

        // Filter by slug
        if (!empty($slug)) {
            $query->where('slug', $slug);
        }

        // If has_child_or_item = false, filter categories with children or products
        if ($has_child_or_item === 'false') {
            // Use whereHas for children or products
            $query->where(function ($q) {
                $q->whereHas('children')
                    ->orWhereHas('products');  // Assuming Category has products() relation
            });
        }

        // Pagination
        if (!is_null($offset)) {
            $query->skip($offset);
        }
        if (!is_null($limit)) {
            $query->take($limit);
        }

        // Sorting
        $query->orderBy($sort, $order);

        // Eager load children
        $categories = $query->with([
            'children' => function ($q) {
                $q->where('status', 1);
            }
        ])->get();

        $countRes = $categories->count();

        // Map categories to add translations and other metadata
        $categories = $categories->map(function ($category) use ($language_code, $level) {
            $category->children = $this->formatSubCategories($category->children, $language_code, $level + 1);

            $category->text = app(TranslationService::class)->getDynamicTranslation(Category::class, 'name', $category->id, $language_code);
            $category->name = $category->text;
            $category->state = ['opened' => true];
            $category->icon = "jstree-folder";
            $category->level = $level;
            $category->image = app(MediaService::class)->dynamic_image(app(MediaService::class)->getImageUrl($category->image, 'thumb', 'sm'), 400);
            $category->banner = app(MediaService::class)->dynamic_image(app(MediaService::class)->getImageUrl($category->banner, 'thumb', 'md'), 400);

            return $category;
        });

        if ($categories->isNotEmpty()) {
            $categories[0]->total = $countRes;
        }

        return Response::json(compact('categories', 'countRes'));
    }
    private function formatSubCategories($subCategories, $language_code, $level)
    {
        return $subCategories->map(function ($category) use ($language_code, $level) {
            $category->children = $this->formatSubCategories($category->children, $language_code, $level + 1);
            $category->text = app(TranslationService::class)->getDynamicTranslation(Category::class, 'name', $category->id, $language_code);
            $category->name = $category->text;
            $category->state = ['opened' => true];
            $category->icon = "jstree-folder";
            $category->level = $level;
            $category->image = app(MediaService::class)->dynamic_image(app(MediaService::class)->getImageUrl($category->image, 'thumb', 'sm'), 400);
            $category->banner = app(MediaService::class)->dynamic_image(app(MediaService::class)->getImageUrl($category->banner, 'thumb', 'md'), 400);
            return $category;
        });
    }

    public function seller_register()
    {
        $store_id = app(StoreService::class)->getStoreId();

        $stores = Store::where('status', 1)->get();

        return view('seller/pages/forms/register', compact('stores'));
    }

    public function sellerStore(Request $request, SellerController $sellerController)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile' => 'required',
            'country_code' => 'required',
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'address' => 'required',
            'store_name' => 'required',
            'account_number' => 'required',
            'account_name' => 'required',
            'bank_name' => 'required',
            'bank_code' => 'required',
            'store_logo' => 'required',
            'store_thumbnail' => 'required',
            'city' => 'required',
            'zipcode' => 'required',
            'description' => 'required',
            'latitude' => 'sometimes|nullable|numeric|between:-90,90',
            'longitude' => 'sometimes|nullable|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($request->ajax()) {
                return response()->json(['errors' => $errors->all()], 422);
            } else {
                $response = [
                    'error' => true,
                    'message' => $validator->errors()->first(),
                    'code' => 102,
                ];
                return response()->json($response);
            }
        } else {
            $res = $sellerController->store($request);
            $responseData = json_decode($res->getContent(), true);

            if (isset($responseData['error_message'])) {
                return response()->json([
                    'message' => $responseData['error_message']
                ]);
            } else {
                return response()->json([
                    'message' => isset($responseData['message']) ? $responseData['message'] : $responseData['errors'],
                    'location' => route('seller.login')
                ]);
            }
        }
    }
    public function delete_selected_data(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id'
        ]);

        foreach ($request->ids as $id) {
            $users = User::find($id);

            if ($users) {
                User::where('id', $id)->delete();
            }
        }
        User::destroy($request->ids);

        return response()->json(['message' => 'Selected data deleted successfully.']);
    }

    public function affiliate_register()
    {
        return view('affiliate/pages/forms/register');
    }
    public function affiliate_login()
    {
        return view('affiliate/pages/forms/login');
    }
    public function affiliate_logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/affiliate/login')->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
