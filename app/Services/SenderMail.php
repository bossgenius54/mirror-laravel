<?php 
namespace App\Services;

use App\Model\Mailing;
use Mail;
use Exception;

class SenderMail {
   
    static function send($email, $title, $note){
        Mail::send('emails.message', array('email' => $email, 'note'=>$note), function($message) use ($email, $title, $note){
            $message->to($email, $email)->subject($title);
        });
    }
}