<?php

namespace App\Http\Controllers\SatuSehat\Encounter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SatuSehat\Encounter\Mapping;
use App\Models\SatuSehat\Practitioner;
use App\Models\SatuSehat\TransactionLog;
use Satusehat\Integration\OAuth2Client;
use Satusehat\Integration\FHIR\Encounter;

class LogTransactionController extends Controller
{
    public function index()
    {
        $logTransactions = TransactionLog::all();

        return view('satusehat.encounter.log.index', compact('logTransactions'));
    }
}
