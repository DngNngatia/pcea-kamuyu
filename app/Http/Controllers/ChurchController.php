<?php

namespace App\Http\Controllers;

use App\Data\Models\Church;
use App\Http\Controllers\Transformers\ChurchTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ChurchController extends Controller
{
    use Helpers;

    public function index()
    {
        $churches = Church::get();
        return $this->response->collection($churches, new ChurchTransformer());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'location' => ['required']
        ]);
        Church::create($request->only('name', 'location', 'lat', 'lng'));
        return $this->index();
    }

    public function update(Request $request, $id)
    {
        $church = Church::findOrfail($id);
        $church->update($request->only('name', 'location', 'lat', 'lng'));
        return $this->index();
    }

    public function destroy($id)
    {
        $church = Church::findOrFail($id);
        $church->delete();
        return $this->index();
    }
}
