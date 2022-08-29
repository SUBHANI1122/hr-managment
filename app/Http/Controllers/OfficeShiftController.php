<?php

namespace App\Http\Controllers;

use App\company;
use App\Country;
use App\office_shift;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Location;
use Carbon;

class OfficeShiftController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request  $request)
    {
        $logged_user = auth()->user();

        $companies = company::select('id', 'company_name')->get();
        $officeTiming = office_shift::first();

		if ($logged_user->can('view-office_shift'))
		{
			if (request()->ajax())
			{
				return datatables()->of(office_shift::with('company')->get())
					->setRowId(function ($office_shift)
					{
						return $office_shift->id;
					})
					->addColumn('company', function ($row)
					{
						return $row->company->company_name ?? ' ';
					})
                    ->addColumn('shift_name', function ($row)
                    {
                        return $row->shift_name ?? ' ';
                    })
                    ->addColumn('monday', function ($row)
                    {

                        return $this->changeShiftTime($row->monday_in, $row->monday_out);
//                        if ($row->monday_in) {
//                                return $row->monday_in . ' To ' . $row->monday_out;
//                        } else {
//                            return '';
//                        }
                    })
                    ->addColumn('tuesday', function ($row)
                    {
                        return $this->changeShiftTime($row->tuesday_in, $row->tuesday_out);
//                        if ($row->tuesday_in) {
//                            return $row->tuesday_in . ' To ' . $row->tuesday_out;
//                        } else {
//                            return '';
//                        }
                    })
                    ->addColumn('wednesday', function ($row)
                    {
                        return $this->changeShiftTime($row->wednesday_in, $row->wednesday_out);
//                        if ($row->wednesday_in) {
//                            return $row->wednesday_in . ' To ' . $row->wednesday_out;
//                        } else {
//                            return '';
//                        }
                    })
                    ->addColumn('thursday', function ($row)
                    {
                        return $this->changeShiftTime($row->thursday_in, $row->thursday_out);
//                        if ($row->thursday_in) {
//                            return $row->thursday_in . ' To ' . $row->thursday_out;
//                        } else {
//                            return '';
//                        }
                    })
                    ->addColumn('friday', function ($row)
                    {
                        return $this->changeShiftTime($row->friday_in, $row->friday_out);
//                        if ($row->friday_in) {
//                            return $row->friday_in . ' To ' . $row->friday_out;
//                        } else {
//                            return '';
//                        }
                    })
                    ->addColumn('saturday', function ($row)
                    {
                        return $this->changeShiftTime($row->saturday_in, $row->saturday_out);
//                        if ($row->saturday_in) {
//                            return $row->saturday_in . ' To ' . $row->saturday_out;
//                        } else {
//                            return '';
//                        }
                    })
                    ->addColumn('sunday', function ($row)
                    {
                        return $this->changeShiftTime($row->sunday_in, $row->sunday_out);
//                        if ($row->sunday_in) {
//                            return $row->sunday_in . ' To ' . $row->sunday_out;
//                        } else {
//                            return '';
//                        }
                    })
					->addColumn('action', function ($data)
					{
						$button = '';
						if (auth()->user()->can('edit-office_shift'))
						{
							$button = '<a id="' . $data->id . '" class="edit btn btn-primary btn-sm" href="' . route('office_shift.edit', $data->id) . '"><i class="dripicons-pencil"></i></a>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-office_shift'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('timesheet.office_shift.index', compact('companies'));
		}

		return abort('403', __('You are not authorized'));
	}

    public  function  changeShiftTime($shift_time_in, $shift_time_out){
        $logged_user = auth()->user();
        $toCountry = $this->getCountryName($logged_user->country ?? 'Pakistan');
        $fromCountryZone = $this->getCountryZone()['Pakistan'];
        $toCountryZone = $this->getCountryZone()[$toCountry->name];
        $in_time = Carbon\Carbon::parse($shift_time_in, $fromCountryZone);
        $in_time = $in_time->setTimezone($toCountryZone)->format('h:i A');

        $out_time = Carbon\Carbon::parse($shift_time_out, $fromCountryZone);
        $out_time = $out_time->setTimezone($toCountryZone)->format('h:i A');

        return $in_time . ' To ' . $out_time;

    }

    public function getCountryZone(){
        return [
            'Pakistan' => 'Asia/Karachi',
            'India' => 'Asia/Kolkata',
        ];
    }
    public function getCountryName($countryId){
        $country = \App\Country::select('name')->where('id', $countryId)->first();
        return $country;
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();

		if ($logged_user->can('store-office_shift'))
		{
			return view('timesheet.office_shift.create', compact('companies'));
		}

		return abort('403', __('You are not authorized'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('store-office_shift'))
		{
			$validator = Validator::make($request->only('shift_name', 'company_id', 'default_shift', 'monday_in', 'monday_out', 'tuesday_in', 'tuesday_out', 'wednesday_in', 'wednesday_out', 'thursday_in', 'thursday_out', 'friday_in', 'friday_out', 'saturday_in', 'saturday_out', 'sunday_in', 'sunday_out'
			),
				[
					'shift_name' => 'required',

				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['shift_name'] = $request->shift_name;
			$data['monday_in'] = $request->monday_in;
			$data['monday_out'] = $request->monday_out;
			$data['tuesday_in'] = $request->tuesday_in;
			$data['tuesday_out'] = $request->tuesday_out;
			$data['wednesday_in'] = $request->wednesday_in;
			$data['wednesday_out'] = $request->wednesday_out;
			$data['thursday_in'] = $request->thursday_in;
			$data['thursday_out'] = $request->thursday_out;
			$data['friday_in'] = $request->friday_in;
			$data['friday_out'] = $request->friday_out;
			$data['saturday_in'] = $request->saturday_in;
			$data['saturday_out'] = $request->saturday_out;
			$data['sunday_in'] = $request->sunday_in;
			$data['sunday_out'] = $request->sunday_out;
			$data['company_id'] = $request->company_id;


			office_shift::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function show($id)
	{

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function edit($id)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('edit-office_shift'))
		{
			$office_shift = office_shift::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$companies = company::select('id', 'company_name')->get();

			return view('timesheet.office_shift.edit', compact('office_shift', 'company_name', 'companies'));
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param int $id
	 * @return Response
	 */
	public function update(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('edit-office_shift'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('shift_name', 'company_id', 'default_shift', 'monday_in', 'monday_out', 'tuesday_in', 'tuesday_out', 'wednesday_in', 'wednesday_out', 'thursday_in', 'thursday_out', 'friday_in', 'friday_out', 'saturday_in', 'saturday_out', 'sunday_in', 'sunday_out'
			),
				[
					'shift_name' => 'required',

				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['shift_name'] = $request->shift_name;
			$data['monday_in'] = $request->monday_in;
			$data['monday_out'] = $request->monday_out;
			$data['tuesday_in'] = $request->tuesday_in;
			$data['tuesday_out'] = $request->tuesday_out;
			$data['wednesday_in'] = $request->wednesday_in;
			$data['wednesday_out'] = $request->wednesday_out;
			$data['thursday_in'] = $request->thursday_in;
			$data['thursday_out'] = $request->thursday_out;
			$data['friday_in'] = $request->friday_in;
			$data['friday_out'] = $request->friday_out;
			$data['saturday_in'] = $request->saturday_in;
			$data['saturday_out'] = $request->saturday_out;
			$data['sunday_in'] = $request->sunday_in;
			$data['sunday_out'] = $request->sunday_out;
			if ($request->company_id)
			{
				$data['company_id'] = $request->company_id;
			}

			office_shift::whereId($id)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-office_shift'))
		{
			office_shift::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);

		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function delete_by_selection(Request $request)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-office_shift'))
		{

			$office_shift_id = $request['officeShiftIdArray'];
			$office_shift = office_shift::whereIn('id', $office_shift_id);
			if ($office_shift->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => __('Office Shift')])]);
			} else
			{
				return response()->json(['error' => 'Error,selected shifts can not be deleted']);
			}
		}

		return response()->json(['success' => __('You are not authorized')]);
	}


}
