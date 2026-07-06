@php
    $title = 'Contactez AURORA MARKETPLACE';
@endphp
<div>
    <x-utility.breadcrumbs.breadcrumbOne :breadcrumb="$title" />

    <!-- Hero Section -->
    <div class="container-fluid py-5 text-center" style="background: linear-gradient(135deg, #fff 0%, #fff8f0 100%); min-height: 380px; display: flex; align-items: center; justify-content: center;">
        <div style="max-width: 900px; padding: 40px 20px;">
            <h1 class="display-5 fw-bold mb-3" style="color: #1a1a2e;">
                <span style="color: #F57C00;">CONTACTEZ</span>-NOUS
            </h1>
            <p class="lead text-muted mx-auto" style="max-width: 700px; font-size: 1.1rem; line-height: 1.7;">
                Une question, une suggestion ou besoin d'assistance ? Notre équipe est là pour vous répondre.
            </p>
            <div class="mt-4">
                <a href="#contact-form" class="btn" style="background: #F57C00; color: #fff; padding: 12px 36px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; text-decoration: none; display: inline-block; transition: all 0.3s; border: none; cursor: pointer;" onmouseover="this.style.background='#e65100'" onmouseout="this.style.background='#F57C00'">Nous écrire</a>
            </div>
        </div>
    </div>

    <div class="container" style="padding: 50px 0;">
        <div class="row g-5" style="max-width: 1000px; margin: 0 auto;">
            <!-- Formulaire -->
            <div class="col-12 col-lg-7">
                <div style="background: #fff; border-radius: 12px; padding: 35px; box-shadow: 0 2px 20px rgba(0,0,0,0.06); border: 1px solid #f0f0f0;">
                    <h2 style="font-size: 22px; font-weight: 700; color: #e65100; margin-bottom: 6px;">Envoyez-nous un message</h2>
                    <p style="font-size: 13px; color: #888; margin-bottom: 22px;">Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais.</p>
                    @if ($errors->has('mailError'))
                        <p class="fw-400 text-danger mt-1" style="font-size: 13px;">{{ $errors->first('mailError') }}</p>
                    @endif
                    <form wire:submit="send_contact_us_email" id="contact-form" class="contact-form">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <input wire:model="name" type="text" class="form-control" placeholder="Votre nom *" style="padding: 11px 15px; border-radius: 8px; border: 1px solid #e5e5e5; font-size: 14px; background: #fafafa;" />
                                @error('name') <p class="fw-400 text-danger mt-1" style="font-size: 12px;">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <input wire:model="email" type="email" class="form-control" placeholder="Votre email *" style="padding: 11px 15px; border-radius: 8px; border: 1px solid #e5e5e5; font-size: 14px; background: #fafafa;" />
                                @error('email') <p class="fw-400 text-danger mt-1" style="font-size: 12px;">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-12">
                                <input wire:model="subject" type="text" class="form-control" placeholder="Sujet *" style="padding: 11px 15px; border-radius: 8px; border: 1px solid #e5e5e5; font-size: 14px; background: #fafafa;" />
                                @error('subject') <p class="fw-400 text-danger mt-1" style="font-size: 12px;">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-12">
                                <textarea wire:model="message" class="form-control" rows="5" placeholder="Votre message *" style="padding: 11px 15px; border-radius: 8px; border: 1px solid #e5e5e5; font-size: 14px; background: #fafafa; resize: vertical;"></textarea>
                                @error('message') <p class="fw-400 text-danger mt-1" style="font-size: 12px;">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn w-100" style="background: #e65100; color: #fff; border: none; padding: 12px; font-size: 14px; font-weight: 600; border-radius: 8px; cursor: pointer; transition: background 0.2s;">Envoyer le message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Infos -->
            <div class="col-12 col-lg-5">
                <div style="background: #fff; border-radius: 12px; padding: 35px; box-shadow: 0 2px 20px rgba(0,0,0,0.06); border: 1px solid #f0f0f0; height: 100%;">
                    <h3 style="font-size: 18px; font-weight: 700; color: #e65100; margin-bottom: 22px;">Nos coordonnées</h3>

                    <div style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 18px;">
                        <div style="width: 40px; height: 40px; min-width: 40px; border-radius: 50%; background: #fff3e0; display: flex; align-items: center; justify-content: center; font-size: 16px;">📍</div>
                        <div>
                            <p style="font-size: 12px; font-weight: 700; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 2px 0;">Adresse</p>
                            <p style="font-size: 14px; color: #333; margin: 0; line-height: 1.5;">195 av Kabambare<br>Commune/Lingwala, Kinshasa, RDC</p>
                        </div>
                    </div>

                    <div style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 18px;">
                        <div style="width: 40px; height: 40px; min-width: 40px; border-radius: 50%; background: #fff3e0; display: flex; align-items: center; justify-content: center; font-size: 16px;">📞</div>
                        <div>
                            <p style="font-size: 12px; font-weight: 700; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 2px 0;">Téléphone</p>
                            <p style="font-size: 14px; color: #333; margin: 0;"><a href="tel:+243860275282" style="color: #e65100; text-decoration: none;">+243 860 275 282</a></p>
                        </div>
                    </div>

                    <div style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 24px;">
                        <div style="width: 40px; height: 40px; min-width: 40px; border-radius: 50%; background: #fff3e0; display: flex; align-items: center; justify-content: center; font-size: 16px;">✉️</div>
                        <div>
                            <p style="font-size: 12px; font-weight: 700; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 2px 0;">Email</p>
                            <p style="font-size: 14px; color: #333; margin: 0;"><a href="mailto:contact@revival-business.com" style="color: #e65100; text-decoration: none;">contact@revival-business.com</a></p>
                        </div>
                    </div>

                    <hr style="border: none; border-top: 1px solid #eee; margin: 0 0 20px 0;">

                    <p style="font-size: 12px; font-weight: 700; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">Suivez-nous</p>
                    <div style="display: flex; gap: 8px;">
                        <a href="https://www.facebook.com/profile.php?id=61587848550970" target="_blank" style="width: 38px; height: 38px; border-radius: 50%; background: #fff3e0; display: flex; align-items: center; justify-content: center; text-decoration: none; color: #e65100; font-size: 17px; transition: all 0.2s;"><i class="anm anm-facebook hdr-icon icon"></i></a>
                        <a href="https://x.com/groupe85249" target="_blank" style="width: 38px; height: 38px; border-radius: 50%; background: #fff3e0; display: flex; align-items: center; justify-content: center; text-decoration: none; color: #e65100; font-size: 17px; transition: all 0.2s;"><i class="anm anm-twitter hdr-icon icon"></i></a>
                        <a href="https://instagram.com/revivalgroup7" target="_blank" style="width: 38px; height: 38px; border-radius: 50%; background: #fff3e0; display: flex; align-items: center; justify-content: center; text-decoration: none; color: #e65100; font-size: 17px; transition: all 0.2s;"><i class="anm anm-instagram hdr-icon icon"></i></a>
                        <a href="https://www.youtube.com/channel/UCCbPABAH4QHmbBntpgSin8Q" target="_blank" style="width: 38px; height: 38px; border-radius: 50%; background: #fff3e0; display: flex; align-items: center; justify-content: center; text-decoration: none; color: #e65100; font-size: 17px; transition: all 0.2s;"><i class="anm anm-youtube hdr-icon icon"></i></a>
                        <a href="https://linkedin.com/company/revival-group-drc" target="_blank" style="width: 38px; height: 38px; border-radius: 50%; background: #fff3e0; display: flex; align-items: center; justify-content: center; text-decoration: none; color: #e65100; font-size: 17px; transition: all 0.2s;"><i class="anm anm-linkedin hdr-icon icon"></i></a>
                    </div>

                    <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">

                    <div>
                        <p style="font-size: 12px; font-weight: 700; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Horaires</p>
                        <p style="font-size: 13px; color: #555; margin: 0; line-height: 1.6;">Lun - Ven : 08h00 - 18h00<br>Sam : 09h00 - 15h00<br>Dim : Fermé</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
