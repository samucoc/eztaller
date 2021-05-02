<?php


namespace App\Services;


use App\Convocatoria;
use App\Mail\EventMail;
use Illuminate\Support\Facades\Mail;

class EmailSender
{
    static function sendDisponibleVisado(Convocatoria $convocatoria)
    {
        $to = $convocatoria->{'email_ate_fosis'};
        if ($to != null && isset($to)) {
            $mail = new EventMail('Proyecto disponible para ser VISADO', 'mails.disponible_visado', [
                'anio' => $convocatoria->{'anio'},
                'comunas' => $convocatoria->{'comunas'}
            ]);
            Mail::to($to)->queue($mail);
        }
    }

    static function sendRechazado(Convocatoria $convocatoria, $motivo)
    {
        $subject = "Proyecto RECHAZADO en la REVISIÓN REGIONAL";
        $options = [
            'anio' => $convocatoria->{'anio'},
            'comunas' => $convocatoria->{'comunas'},
            'motivo' => $motivo
        ];
        $to = $convocatoria->{'email_ate_fosis'};
        if ($to != null && isset($to)) {
            $options['role'] = 'Asistente Técnico FOSIS';
            $mail = new EventMail($subject, 'mails.rechazado', $options);
            Mail::to($to)->queue($mail);
        }

        $emails = ['email_ejec_social', 'email_ejec_const', 'email_enc_ejec'];
        $to = [];
        foreach ($emails as $email) {
            if ($email != null && isset($email)) {
                $to[] = $convocatoria->{$email};
            }
        }
        if (count($to) > 0) {
            $options['role'] = 'Equipo Ejecutor Habitabilidad';
            $mail = new EventMail($subject, 'mails.rechazado', $options);
            Mail::to($to)->queue($mail);
        }
    }

    static function sendVisado(Convocatoria $convocatoria)
    {
        $to = $convocatoria->{'email_enc_prog_seremi'};
        if ($to != null && isset($to)) {
            $mail = new EventMail('Proyecto disponible para ser REVISADO REGIONALMENTE', 'mails.visado', [
                'anio' => $convocatoria->{'anio'},
                'comunas' => $convocatoria->{'comunas'}
            ]);
            Mail::to($to)->queue($mail);
        }
    }

    static function getCc()
    {
        $cc = env('MAIL_CC', '');
        return explode(',', $cc);
    }
}