<?php
namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Administrator\BaseController;
use App\Models\Locale;

class IndexController extends BaseController
{
    /*
     * Display the dashboard page
     */
    public function dashboard()
    {
        $displayStatistics = \Teknoza::statisticsCheckCredentialsFile();

        if($displayStatistics) {

            try {
                $visitorsAndPageViewsToday = $this->cached('countVisitorsAndPageViewsToday');
                $visitorsAndPageViewsYesterday = $this->cached('countVisitorsAndPageViewsYesterday');

                $percentVisitorsChangeTodayYesterday = 0;
                $percentPageViewsChangeTodayYesterday = 0;
                if ($visitorsAndPageViewsYesterday->visitors > 0 && $visitorsAndPageViewsYesterday->pageViews > 0) {
                    $percentVisitorsChangeTodayYesterday = (int)((($visitorsAndPageViewsToday->visitors - $visitorsAndPageViewsYesterday->visitors) * 100) / $visitorsAndPageViewsYesterday->visitors);
                    $percentPageViewsChangeTodayYesterday = (int)((($visitorsAndPageViewsToday->pageViews - $visitorsAndPageViewsYesterday->pageViews) * 100) / $visitorsAndPageViewsYesterday->pageViews);
                }

                $visitorsAndPageViewsThisMonth = $this->cached('countVisitorsAndPageViewsThisMonth');
                $visitorsAndPageViewsLastMonth = $this->cached('countVisitorsAndPageViewsLastMonth');

                $percentVisitorsChangeThisMonthLastMonth = 0;
                $percentPageViewsChangeThisMonthLastMonth = 0;
                if ($visitorsAndPageViewsLastMonth->visitors > 0 && $visitorsAndPageViewsLastMonth->pageViews > 0) {
                    $percentVisitorsChangeThisMonthLastMonth = (int)((($visitorsAndPageViewsThisMonth->visitors - $visitorsAndPageViewsLastMonth->visitors) * 100) / $visitorsAndPageViewsLastMonth->visitors);
                    $percentPageViewsChangeThisMonthLastMonth = (int)((($visitorsAndPageViewsThisMonth->pageViews - $visitorsAndPageViewsLastMonth->pageViews) * 100) / $visitorsAndPageViewsLastMonth->pageViews);
                }

                $return = [
                    'displayStatistics' => $displayStatistics,
                    'jsonLastDay' => $this->cached('generateJsonLastDay'),
                    'jsonLastMonth' => $this->cached('generateJsonLastMonth'),
                    'visitorsAndPageViewsToday' => $visitorsAndPageViewsToday,
                    'visitorsAndPageViewsYesterday' => $visitorsAndPageViewsYesterday,
                    'percentVisitorsChangeTodayYesterday' => $percentVisitorsChangeTodayYesterday,
                    'percentPageViewsChangeTodayYesterday' => $percentPageViewsChangeTodayYesterday,
                    'visitorsAndPageViewsThisMonth' => $visitorsAndPageViewsThisMonth,
                    'visitorsAndPageViewsLastMonth' => $visitorsAndPageViewsLastMonth,
                    'percentVisitorsChangeThisMonthLastMonth' => $percentVisitorsChangeThisMonthLastMonth,
                    'percentPageViewsChangeThisMonthLastMonth' => $percentPageViewsChangeThisMonthLastMonth,
                ];
            } catch (\Spatie\Analytics\Exceptions\InvalidConfiguration $exception) {
                $return = [
                    'displayStatistics' => $displayStatistics
                ];
            }
        } else {
            $return = [
                'displayStatistics' => $displayStatistics
            ];
        }

        return view('administrator.index', $return);
    }

    private function cached($method, array $args = [])
    {
        if(\Cache::has('method_this_' . $method)){
            $cache = \Cache::get('method_this_' . $method);
        }else{
            $cache = $this->$method();
            \Cache::put('method_this_' . $method, $cache, 60);
        }
        return $cache;
    }

    private function countVisitorsAndPageViewsToday()
    {
        $startTime = new \DateTime('today');
        $endTime = new \DateTime('tomorrow -1 second');

        $analyticsData = \Analytics::fetchTotalVisitorsAndPageViews(\Spatie\Analytics\Period::create($startTime, $endTime));

        $visitors = (int) $analyticsData[0]['visitors'];
        $pageViews = (int) $analyticsData[0]['pageViews'];

        return (object) ['visitors' => $visitors, 'pageViews' => $pageViews];
    }

    private function countVisitorsAndPageViewsYesterday()
    {
        $startTime = new \DateTime('yesterday');
        $endTime = new \DateTime('today -1 second');

        $analyticsData = \Analytics::fetchTotalVisitorsAndPageViews(\Spatie\Analytics\Period::create($startTime, $endTime));

        $visitors = (int) $analyticsData[0]['visitors'];
        $pageViews = (int) $analyticsData[0]['pageViews'];

        return (object) ['visitors' => $visitors, 'pageViews' => $pageViews];
    }

    private function countVisitorsAndPageViewsThisMonth()
    {
        $startTime = new \DateTime('-1 month');
        $endTime = new \DateTime('now');

        $analyticsData = \Analytics::fetchTotalVisitorsAndPageViews(\Spatie\Analytics\Period::create($startTime, $endTime));

        $visitors = 0;
        $pageViews = 0;
        foreach($analyticsData as $data){
            $visitors += $data['visitors'];
            $pageViews += $data['pageViews'];
        }

        return (object) ['visitors' => $visitors, 'pageViews' => $pageViews];
    }

    private function countVisitorsAndPageViewsLastMonth()
    {
        $startTime = new \DateTime('-2 months');
        $endTime = new \DateTime('-1 month');

        $analyticsData = \Analytics::fetchTotalVisitorsAndPageViews(\Spatie\Analytics\Period::create($startTime, $endTime));

        $visitors = 0;
        $pageViews = 0;
        foreach($analyticsData as $data){
            $visitors += $data['visitors'];
            $pageViews += $data['pageViews'];
        }

        return (object) ['visitors' => $visitors, 'pageViews' => $pageViews];
    }

    private function generateJsonLastDay()
    {
        $analyticsData = \Analytics::performQuery(\Spatie\Analytics\Period::days(1), 'ga:pageviews', ['dimensions' => 'ga:dateHour']);

        $gJson = [];

        if($analyticsData->rows){
            foreach($analyticsData->rows as $row){
                $date = $row['0'];
                $year = substr($date, 0, 4);
                $month = substr($date, 4, 2);
                $day = substr($date, 6, 2);
                $hour = substr($date, 8, 2);
                $time = mktime($hour, 0, 0, $month, $day, $year);
                $gJson[] = ['hour' => date('Y-m-d H:00', $time), 'visitors' => $row[1]];
            }
        }

        return json_encode($gJson);
    }

    private function generateJsonLastMonth()
    {
        $analyticsData = \Analytics::fetchTotalVisitorsAndPageViews(\Spatie\Analytics\Period::days(31));

        $gJson = [];

        foreach($analyticsData as $row){
            $gJson[] = ['day' => (string) $row['date'], 'visitors' => $row['visitors']];
        }

        return json_encode($gJson);
    }
    
    /*
     * Change the default locale
     */
    public function locale($locale_id)
    {
        $locale = Locale::find($locale_id);
        if(!$locale) {
            return redirect('administrator');
        }
        
        \Auth::user()->locale_id = $locale_id;
        \Auth::user()->save();
        
        return redirect('administrator');
    }
}
