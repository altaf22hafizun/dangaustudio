<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verifikasi Alamat Email Anda')
                ->greeting('Halo!')
                ->line('Kami sangat senang Anda bergabung dengan kami! Untuk melanjutkan, mohon verifikasi alamat email Anda.')
                ->action('Verifikasi Sekarang', $url)
                ->line('Jika Anda tidak mendaftar, cukup abaikan email ini.')
                ->line('Terima kasih atas kepercayaan Anda kepada kami!')
                ->salutation('Salam hangat, Tim Dangau Studio');
        });
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {

            $url = url('reset-password/' . $token);

            return (new MailMessage)
                ->subject('Reset Kata Sandi')
                ->greeting('Halo!')
                ->line('Kami menerima permintaan untuk mereset kata sandi Anda.')
                ->action('Reset Password', $url)
                ->line('Terima kasih telah menggunakan aplikasi kami!')
                ->salutation('Salam, Tim Dangau Studio');
        });
    }
}
