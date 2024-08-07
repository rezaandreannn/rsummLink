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

    public function handle(Request $request, Closure $next, $roles)
    {
        $application = $this->getApplication($request->segment(1));

        if (!$application) {
            abort(404, 'Application not found.');
        }

        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $roleNames = explode(',', $roles);
        $roles = Role::where('application_id', $application->id)
            ->get();

        if ($roles->isEmpty()) {
            abort(403, 'Unauthorized action.');
        }

        $userHasRole = false;
        foreach ($roles as $role) {
            if ($user->hasRole($role) || $user->hasRole('superadmin')) {
                $userHasRole = true;
                break;
            }
        }


        if (!$userHasRole) {
            abort(403, 'Unauthorized action.');
        }

        // Simpan aplikasi yang sedang diakses dalam request
        $request->attributes->set('application', $application);

        return $next($request);
    }

    private function getApplication($segment)
    {
        $applications = Application::all();
        $applicationMap = [];

        foreach ($applications as $application) {
            $applicationMap[$application->prefix] = $application->name;
        }

        if (array_key_exists($segment, $applicationMap)) {
            return Application::where('name', $applicationMap[$segment])->first();
        }
        // // Mapping segmen URL ke nama aplikasi
        // $app = Application::all();
        // $applicationMap = [
        //     'satusehat' => 'satu sehat',
        //     'v-claimbpjs' => 'v-claim bpjs',
        // ];

        // if (array_key_exists($segment, $applicationMap)) {
        //     return Application::where('name', $applicationMap[$segment])->first();
        // }

        return null;
    }
}
