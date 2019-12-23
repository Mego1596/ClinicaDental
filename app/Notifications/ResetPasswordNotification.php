<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
class ResetPasswordNotification extends Notification
{
    use Queueable;
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('clinicayekixpaki@gmail.com','Sana Dental')
            ->subject('Restablecimineto de contraseña') // it will use this class name if you don't specify
            ->greeting('Hola '.$notifiable->persona->primer_nombre." ".$notifiable->persona->primer_apellido)
            ->level('info')// It is kind of email. Available options: info, success, error. Default: info
            ->line(Lang::getFromJson('Recibes este email porque se solicitó un reestablecimiento de contraseña para tu cuenta.'))
            ->action(Lang::getFromJson('Reestablecer contraseña'), url(config('app.url').route('password.reset', $this->token, false)))
            ->line(Lang::getFromJson('Si tú no has realizado esta actividad, solo ignora el mensaje'));
//          ->salutation('')  // example: best regards, thanks, etc ...
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
