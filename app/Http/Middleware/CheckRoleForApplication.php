<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Application;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class CheckRoleForApplication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next, $role)
    {

        $application = $this->getApplication($request->segment(1)); // Ambil segmen pertama dari URL

        if (!$application) {
            abort(404, 'Application not found.');
        }

        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $roles = Role::where(['name' => $role, 'application_id' => $application->id])->get();
        // dd($roleGet);
        if ($roles->isNotEmpty()) {
            foreach ($roles as $roleUser) {
                if (!$user->hasRole($roleUser)) {
                    // Pengguna memiliki peran yang sedang dilooping
                    // dd($roleUser->id);
                    abort(403, 'Unauthorized action.');
                    // Lakukan sesuatu di sini
                    break; // Anda dapat menghentikan loop jika peran yang ditemukan cukup
                }
            }
        } else {
            abort(403, 'Unauthorized action.');
            // Tidak ada peran yang sesuai dengan kueri yang diberikan
        }
        // if (!$user->roles()->where('application_id', $application->id)->where('id', $roleId)->exists()) {
        //     abort(403, 'Unauthorized action.');
        // }
        // if (!$user->roles($application->id)->where('name', $role)->exists()) {
        //     // if (!Role::where([
        //     //     'application_id' => $application->id,
        //     //     'name' => $role
        //     // ])) {
        //     abort(403, 'Unauthorized action.');
        // }
        // }
        // if (!$user->hasRole($role, $application->id)) {
        //     abort(403, 'Unauthorized action.');
        // }

        // Simpan aplikasi yang sedang diakses dalam request
        $request->attributes->set('application', $application);

        return $next($request);
    }

    private function getApplication($segment)
    {
        // Mapping segmen URL ke nama aplikasi
        $applicationMap = [
            'satusehat' => 'satu sehat',
            'v-claimbpjs' => 'v-claim bpjs',
        ];

        if (array_key_exists($segment, $applicationMap)) {
            return Application::where('name', $applicationMap[$segment])->first();
        }

        return null;
    }
}
