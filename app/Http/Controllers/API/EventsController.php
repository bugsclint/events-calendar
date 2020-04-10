<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Event;

class EventsController extends Controller {

    public function index(Request $request) {
        $data = [];
        $input = $request->all();
        $from = date('Y-m-d', strtotime($input['start']));
        $to = date('Y-m-d', strtotime($input['end']));
        $events = Event::whereBetween('from', [$from, $to])
                ->orWhereBetween('to', [$from, $to])
                ->get();
        foreach ($events as $key => $row) {
            $days = false;
            if ($row['mondays']) {
                $dates = $this->_getDatesInRange($from, $to, 'monday');
                if ($dates) {
                    foreach ($dates as $date) {
                        $data[] = [
                            'title' => $row['event'],
                            'start' => $date,
                        ];
                    }
                    $days = true;
                }
            }

            if ($row['tuesdays']) {
                $dates = $this->_getDatesInRange($from, $to, 'tuesday');
                if ($dates) {
                    foreach ($dates as $date) {
                        $data[] = [
                            'title' => $row['event'],
                            'start' => $date,
                        ];
                    }
                    $days = true;
                }
            }

            if ($row['wednesdays']) {
                $dates = $this->_getDatesInRange($from, $to, 'wednesdays');
                if ($dates) {
                    foreach ($dates as $date) {
                        $data[] = [
                            'title' => $row['event'],
                            'start' => $date,
                        ];
                    }
                    $days = true;
                }
            }

            if ($row['thursdays']) {
                $dates = $this->_getDatesInRange($from, $to, 'thursdays');
                if ($dates) {
                    foreach ($dates as $date) {
                        $data[] = [
                            'title' => $row['event'],
                            'start' => $date,
                        ];
                    }
                    $days = true;
                }
            }

            if ($row['fridays']) {
                $dates = $this->_getDatesInRange($from, $to, 'fridays');
                if ($dates) {
                    foreach ($dates as $date) {
                        $data[] = [
                            'title' => $row['event'],
                            'start' => $date,
                        ];
                    }
                    $days = true;
                }
            }

            if ($row['saturdays']) {
                $dates = $this->_getDatesInRange($from, $to, 'saturdays');
                if ($dates) {
                    foreach ($dates as $date) {
                        $data[] = [
                            'title' => $row['event'],
                            'start' => $date,
                        ];
                    }
                    $days = true;
                }
            }

            if ($row['sundays']) {
                $dates = $this->_getDatesInRange($from, $to, 'sundays');
                if ($dates) {
                    foreach ($dates as $date) {
                        $data[] = [
                            'title' => $row['event'],
                            'start' => $date,
                        ];
                    }
                    $days = true;
                }
            }

            if ($days == false) {
                $data[] = [
                    'title' => $row['event'],
                    'start' => $row['from'],
                    'end' => date('Y-m-d', strtotime($row['to'] . ' +1 day')),
                ];
            }
        }
        return response()->json($data);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
                    'event' => 'required|max:255',
                    'from' => 'required|date',
                    'to' => 'required|date|after_or_equal:from'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                        'error' => [
                            'code' => 'FIELDS_VALIDATION_ERROR',
                            'message' => 'One or more fields raised validation errors.',
                            'fields' => $errors
                        ]
            ]);
        }
        $input = $request->all();
        $input['from'] = !empty($input['from']) ? date('Y-m-d', strtotime($input['from'])) : null;
        $input['to'] = !empty($input['to']) ? date('Y-m-d', strtotime($input['to'])) : null;
        $input['mondays'] = !empty($input['mondays']) ? true : false;
        $input['tuesdays'] = !empty($input['tuesdays']) ? true : false;
        $input['wednesdays'] = !empty($input['wednesdays']) ? true : false;
        $input['thursdays'] = !empty($input['thursdays']) ? true : false;
        $input['fridays'] = !empty($input['fridays']) ? true : false;
        $input['saturdays'] = !empty($input['saturdays']) ? true : false;
        $input['sundays'] = !empty($input['sundays']) ? true : false;
        $event = Event::create($input);
        return response()->json(['data' => $event]);
    }

    private function _getDatesInRange($from, $to, $day) {
        $dateFrom = new \DateTime($from);
        $dateTo = new \DateTime($to);
        $dates = [];

        if ($dateFrom > $dateTo) {
            return $dates;
        }

        if (1 != $dateFrom->format('N')) {
            $dateFrom->modify('next ' . $day);
        }

        while ($dateFrom <= $dateTo) {
            $dates[] = $dateFrom->format('Y-m-d');
            $dateFrom->modify('+1 week');
        }

        return $dates;
    }

}
