<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\ZipCode;
use Illuminate\Support\Facades\DB;

class GasStationController extends Controller
{
    /*
    *   Service for get and filter Api Gas
    */
    public function index()
    {
        $response = Http::get('https://api.datos.gob.mx/v1/precio.gasolina.publico?pageSize=20')['results'];
        return response()->json(['data' => $response]);
    }

    /*
    *   Service for save Zip Codes from txt
    */
    public function saveZipCodes() {
        $count = 1;
        $file = fopen(storage_path('app/public/CPdescarga.txt'), 'r');
        while(!feof($file)) {
            $read = fgets($file);
            $data = explode('|', utf8_encode($read));
            $this->saveZipCode($data);
            $count++;
        }
        fclose($file);
        return 'Se insertaron ' . $count . ' registros en la tabla';
    }

    /*
    *   Service to get States
    */
    public function getStates() {
        $states = DB::table('zip_codes')
            ->select('state')
            ->distinct()
            ->groupBy('state')
            ->get();
        return response()->json(['data' => $states]);
    }

    /*
    *   Service to get Municipality by State
    */
    public function getMunicipalities($state) {
        $municipalities = DB::table('zip_codes')
            ->select('municipality')
            ->distinct()
            ->where(['state' => $state])
            ->groupBy('municipality')
            ->get();
        return response()->json(['data' => $municipalities]);
    }

    /*
    *   Service to get ZipCodes by State and Municipality
    */
    public function getZipCodes($state, $municipality) {
        $dataGas = $this->index();
        $dataGas = $dataGas->getData()->data;
        $data = ZipCode::where([
            'state' => $state,
            'municipality' => $municipality
        ])
        ->get();
        $arrayZipCodes = [];
        foreach ($data as $value) {
            $zc = $value->zip_code;
            $arrayFilter = array_filter($dataGas, function ($val) use ($zc) {
                return $val->codigopostal == $zc;
            }, ARRAY_FILTER_USE_BOTH);
            if(count($arrayFilter) > 0) {
                $filter = $this->getUniqueElement($arrayFilter);
                $objZipCode = [
                    'id' => $value->id,
                    'zip_code' => $value->zip_code,
                    'state' => $value->state,
                    'city' => $value->city,
                    'municipality' => $value->municipality,
                    'settling' => $value->settling,
                    '_id' => $filter->_id,
                    'calle' => $filter->calle,
                    'rfc' => $filter->rfc,
                    'date_insert' => $filter->date_insert,
                    'regular' => $filter->regular,
                    'colonia' => $filter->colonia,
                    'numeropermiso' => $filter->numeropermiso,
                    'fechaaplicacion' => $filter->fechaaplicacion,
                    'longitude' => $filter->longitude,
                    'latitude' => $filter->latitude,
                    'premium' => $filter->premium,
                    'razonsocial' => $filter->razonsocial,
                    'codigopostal' => $filter->codigopostal,
                    'dieasel' => $filter->dieasel
                ];
                array_push($arrayZipCodes, $objZipCode);
            }
        }
        return response()->json(['data' => $arrayZipCodes]);
    }

    public function getUniqueElement($arrayFilter) {
        $obj = null;
        foreach ($arrayFilter as $value) {
            $obj = $value;
        }
        return $obj;
    }

    public function saveZipCode($data) {
        $zipCode = new ZipCode();
        $zipCode->zip_code = $data[0];
        $zipCode->settling = $data[1];
        $zipCode->type_settling = $data[2];
        $zipCode->municipality = $data[3];
        $zipCode->state = $data[4];
        $zipCode->city = $data[5];
        $zipCode->settling_zip_code = $data[6];
        $zipCode->key_entity = $data[7];
        $zipCode->office_zip_code = $data[8];
        $zipCode->empty_zip_code = $data[9];
        $zipCode->key_municipality = $data[10];
        $zipCode->settling_id = $data[11];
        $zipCode->settling_zone = $data[12];
        $zipCode->key_city = $data[13];
        $zipCode->save();
    }
}
