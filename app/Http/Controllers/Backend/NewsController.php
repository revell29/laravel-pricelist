<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MsNews;
use DataTables;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MsNews::withTrashed()->select("*");

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('judul', function ($item) {
                    return '<a href="' . route('news.edit', $item->id) . '">' . $item->judul . '</a>';
                })
                ->editColumn('deleted_at', function ($item) {
                    $green = "<span style='color: green'><i class='icon-checkmark'></i></span>";
                    $red = "<span style='color: red'><i class='icon-x'></i></span>";
                    return is_null($item->deleted_at) ? $green : $red;
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('pages.news.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.news.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        MsNews::create(['judul' => $request->judul, 'description' => $request->description]);
        return response()->json(['message' => 'Berita berhasil ditambahkan.'], 200);
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
        $data = MsNews::find($id);
        return view('pages.news.create_edit', compact('data'));
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
        $data = MsNews::find($id);
        $data->update(['judul' => $request->judul, 'description' => $request->description]);
        return response()->json(['message' => 'Berita berhasil diperbarui.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MsNews::withTrashed()->whereIn('id', explode(',', $id))->delete();
        return response()->json(['message' => 'Berita dinonaktifkan'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        MsNews::withTrashed()->whereIn('id', explode(',', $id))->restore();
        return response()->json(['message' => 'Berita diaktifkan'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {
        MsNews::withTrashed()->whereIn('id', explode(',', $id))->forceDelete();
        return response()->json(['message' => 'Berita dihapus'], 200);
    }
}
