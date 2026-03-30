<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReferralcodeFormRequest;
use App\Models\Referralcode;
use Illuminate\Support\Str;

class ReferralController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:referrals.view')->only(['index', 'show']);
        $this->middleware('can-access:referrals.create')->only(['create', 'update']);
        $this->middleware('can-access:referrals.update')->only('edit');
        $this->middleware('can-access:referrals.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $referralcodes = Referralcode::withCount(['users', 'user'])->latest()->paginate();

        return view('dashboard.referrals.index', ['referralcodes'=>$referralcodes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $code = Str::random(30);

        return view('dashboard.referrals.create', ['code' => $code]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $referralcode = Referralcode::with(['user', 'users' => function ($query) {
            $query->withCount('orders');
        }])
            ->findOrFail($id);

        return view('dashboard.referrals.show', ['referralcode'=>$referralcode]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $code =  Referralcode::with(['user'])->findOrFail($id);

        return view('dashboard.referrals.edit', ['code' => $code]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ReferralcodeFormRequest $request)
    {
        $data =  $request->validated();
        $data['user_id'] = $data['selected'];
        $data['status'] = $data['status']?? Referralcode::STATUS_ACTIVE;

        Referralcode::create($data);

        return redirect()->route('referrals.index')
            ->with([
                'message' =>[
                    'type' => 'success',
                    'message' => trans('commons.created_successfully'),
                ],
            ]);
    }

    /**
     * Update created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ReferralcodeFormRequest $request, $referralCodeId)
    {
        $data =  $request->validated();
        $data['user_id'] = $data['selected'];
        if (isset($data['status']) && $data['status'] = 'on') {
            $data['status'] =  Referralcode::STATUS_ACTIVE;
        } else {
            $data['status'] = 0;
        }

        unset($data['selected']);
        Referralcode::where('id', $referralCodeId)->update($data);

        return redirect()->route('referrals.index')
            ->with([
                'message' =>[
                    'type' => 'success',
                    'message' => trans('commons.created_successfully'),
                ],
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $referralcode)
    {
        Referralcode::where('id', $referralcode)->delete();

        return redirect()->route('referrals.index')
            ->with([
                'message' =>[
                    'type' => 'success',
                    'message' => trans('commons.deleted_successfully'),
                    ],
        ]);
    }
}
