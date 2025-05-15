<?

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function index()
    {
        return view('auth.otp');
    }

    public function verify(Request $request)
    {
        $input = implode('', $request->input('otp'));
        $otp = session('otp_code');

        if ($input == $otp) {
            // Jika cocok
            session()->forget('otp_code');
            return redirect()->route('dashboard')->with('success', 'Verifikasi berhasil!');
        }

        return back()->with('error', 'Kode OTP salah, silakan coba lagi.');
    }

    public function resend()
    {
        $otp = rand(1000, 9999);
        session(['otp_code' => $otp]);

        // Kirim ulang ke email user
        Mail::raw("Kode OTP Anda adalah: $otp", function ($message) {
            $message->to(auth()->user()->email)
                    ->subject('Kode OTP Zoovia');
        });

        return back()->with('success', 'Kode OTP telah dikirim ulang ke email Anda.');
    }
}
