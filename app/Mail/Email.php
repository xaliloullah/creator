<?php



namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    protected $objet;
    protected $viewName;
    protected $data;

    public function __construct($objet = 'Email', $viewName, array $data)
    {
        $this->objet = $objet;
        $this->viewName = $viewName;
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject($this->objet)->view("emails.$this->viewName")->with(['data' => $this->data]);
    }
}
