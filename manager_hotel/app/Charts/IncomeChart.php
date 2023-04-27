<?php

namespace App\Charts;

use App\Repositories\Eloquent\BookingRepository;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class IncomeChart
{
    protected $chart;
    protected $bookingRepository;

    public function __construct(LarapexChart $chart)
    {
        $this->bookingRepository = app(BookingRepository::class);
        $this->chart = $chart;
    }

    public function build(): array
    {
        $incomeByDay = is_null($this->bookingRepository->getTotalMoneyByDay()->total_money) ? 0 : $this->bookingRepository->getTotalMoneyByDay()->total_money;
        $incomeByWeek = is_null($this->bookingRepository->getTotalMoneyByWeek()->total_money) ? 0 : $this->bookingRepository->getTotalMoneyByWeek()->total_money;
        $incomeByMonth = is_null($this->bookingRepository->getTotalMoneyByMonth()->total_money) ? 0 : $this->bookingRepository->getTotalMoneyByMonth()->total_money;
        $totalIncome = $incomeByDay + $incomeByWeek + $incomeByMonth;

        if($totalIncome != 0) {
            $percentByDay = floor(($incomeByDay/$totalIncome) * 100);
            $percentByWeek = floor(($incomeByWeek/$totalIncome) * 100);
            $percentByMonth = floor(($incomeByMonth/$totalIncome) * 100);
        }else {
            $percentByDay = 0;
            $percentByWeek = 0;
            $percentByMonth = 0;
        }

        return $this->chart->donutChart()
            ->setTitle('Income percent')
            ->addData([$percentByDay, $percentByWeek, $percentByMonth])
            ->setLabels(['Today', 'This week', 'This month'])
            ->toVue();
    }
}
