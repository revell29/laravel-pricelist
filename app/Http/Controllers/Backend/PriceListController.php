<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PriceList;
use DB;
use DataTables;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use File;
use Storage;

class PriceListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PriceList::select("*");
            return DataTables::of($data)
                ->escapeColumns([])
                ->make(true);
        }

        return view('pages.pricelist.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function import(Request $request)
    {
        $msgList = array();
        $file = $request->file('files');
        $filename = \Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path("export-excel"), $filename);
        $path = '/export-excel/' . $filename;
        /*Import File Load*/
        $spreadsheet = IOFactory::load(public_path() . $path);

        /*Set Active Sheet Index*/
        $spreadsheet->setActiveSheetIndex(0);

        /*Row and Column starting Index*/
        $maxCell = $spreadsheet->getActiveSheet()->getHighestRowAndColumn();
        $DataList = $spreadsheet->getActiveSheet()->rangeToArray('A3:' . $maxCell['column'] . $maxCell['row']);

        $Rows = collect($DataList);

        /*Row count*/
        // $TotalRow = count($DataList);
        $TotalRow = $Rows->count();
        if ($TotalRow > 0) {

            // initiate the transaction
            DB::beginTransaction();
            DB::table('price_lists')->truncate();

            try {

                //Foreach Loop
                foreach ($DataList as $key => $row) {
                    //Insert sql
                    DB::table('price_lists')->insert([
                        'barcode' => $row[1],
                        'item_name' => $row[2],
                        'popular_name' => $row[3],
                        'satuan' => $row[4],
                        'price_1' => $this->replaceComma($row[5]),
                        'price_2' => $this->replaceComma($row[6]),
                        'price_3' => $this->replaceComma($row[7]),
                    ]);
                }

                DB::commit();

                //Success Message
                $msgList["msgType"] = 'success';
                $msgList['message'] = '<span class="done">The file uploaded successfully. </span>See the result: <a target="_blank" href="' . url('excel-imported-data-list') . '">click here</a>';
                return response()->json($msgList, 200);
            } catch (\Exception $e) {

                //Error Message
                $msgList["msgType"] = 'error';
                $msgList['message'] = '<span class="red">' . $e->getMessage() . '</span>';

                DB::rollback();
                return response()->json($msgList, 200);
            }
        } else {

            //Error Message
            $msgList["msgType"] = 'error';
            $msgList['message'] = '<span class="red">There are no data in your Excel File. Please enter data in your Excel File.</span>';
            return response()->json($msgList, 500);
        }
    }

    //Comma Replace Function
    private function replaceComma($value)
    {

        if ($value != '0') {
            return (is_null($value) || empty($value) ? "NULL" : str_replace(',', '', $value));
        } else {
            return $value;
        }
    }

    public function download(Request $request)
    {
        return response()->download(public_path('global_assets/template-pricelist.xlsx'));
    }
}
