<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function superadminindex()
    {
        $channel = Channel::orderBy('created_at', 'desc')->get();
        return view ('superadmin.channel.index',[
            'channel'=> $channel,
        ]);
    }

    public function superadmincreate()
    {
        return view ('superadmin.channel.create');
    }

    public function superadminstore(Request $request)
    {
        

        $kodechannel = $request -> kode_channel;
        $namachannel = $request -> nama_channel;

        Channel::create([
           'kode_channel' => $kodechannel,
           'nama_channel' => $namachannel,
        ]);

        $request->session()->flash('success', 'Channel berhasil ditambahkan');

        return redirect(route('superadmin.channel.index'));
    }

    public function superadminshow ($id){
        $data = Channel::find($id);

        return view('superadmin.channel.edit',[
            'data' => $data,
        ]);
    }

    public function superadminupdate(Request $request, $id){

        $data = Channel::find($id);
        $data->kode_channel = $request->kode_channel;
        $data -> nama_channel = $request -> nama_channel;
        $data->save();
        $request->session()->flash('success', 'Channel berhasil diubah');

        return redirect(route('superadmin.channel.index'));
    }

    public function adminprodukdestroy(Request $request, $id)
    {
        $channel = Channel::find($id);
        $channel -> delete();


         $request->session()->flash('success', 'Channel berhasil dihapus');

        return redirect(route('superadmin.channel.index'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function leaderindex()
    {
        $channel = Channel::orderBy('created_at', 'desc')->get();
        return view ('leader.channel.index',[
            'channel'=> $channel,
        ]);
    }

    public function leadercreate()
    {
        return view ('leader.channel.create');
    }

    public function leaderstore(Request $request)
    {
        

        $kodechannel = $request -> kode_channel;
        $namachannel = $request -> nama_channel;

        Channel::create([
           'kode_channel' => $kodechannel,
           'nama_channel' => $namachannel,
        ]);

        $request->session()->flash('success', 'Channel berhasil ditambahkan');

        return redirect(route('leader.channel.index'));
    }

    public function leadershow ($id){
        $data = Channel::find($id);

        return view('leader.channel.edit',[
            'data' => $data,
        ]);
    }

    public function leaderupdate(Request $request, $id){

        $data = Channel::find($id);
        $data->kode_channel = $request->kode_channel;
        $data -> nama_channel = $request -> nama_channel;
        $data->save();
        $request->session()->flash('success', 'Channel berhasil diubah');

        return redirect(route('leader.channel.index'));
    }

    public function leaderdestroy(Request $request, $id)
    {
        $channel = Channel::find($id);
        $channel -> delete();


         $request->session()->flash('success', 'Channel berhasil dihapus');

        return redirect(route('leader.channel.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    public function managerindex()
    {
        $channel = Channel::orderBy('created_at', 'desc')->get();
        return view ('manager.channel.index',[
            'channel'=> $channel,
        ]);
    }

    public function managercreate()
    {
        return view ('manager.channel.create');
    }

    public function managerstore(Request $request)
    {
        

        $kodechannel = $request -> kode_channel;
        $namachannel = $request -> nama_channel;

        Channel::create([
           'kode_channel' => $kodechannel,
           'nama_channel' => $namachannel,
        ]);

        $request->session()->flash('success', 'Channel berhasil ditambahkan');

        return redirect(route('manager.channel.index'));
    }

    public function managershow ($id){
        $data = Channel::find($id);

        return view('manager.channel.edit',[
            'data' => $data,
        ]);
    }

    public function managerupdate(Request $request, $id){

        $data = Channel::find($id);
        $data->kode_channel = $request->kode_channel;
        $data -> nama_channel = $request -> nama_channel;
        $data->save();
        $request->session()->flash('success', 'Channel berhasil diubah');

        return redirect(route('manager.channel.index'));
    }

    public function managerdestroy(Request $request, $id)
    {
        $channel = Channel::find($id);
        $channel -> delete();


         $request->session()->flash('success', 'Channel berhasil dihapus');

        return redirect(route('manager.channel.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
