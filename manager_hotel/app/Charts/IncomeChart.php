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
        $incomeByDay = $this->bookingRepository->getTotalMoneyByDay();
        $incomeByWeek = $this->bookingRepository->getTotalMoneyByWeek();
        $incomeByMonth = $this->bookingRepository->getTotalMoneyByMonth();
        return $this->chart->donutChart()
            ->setTitle('Top 3 scorers of the team.')
            ->setSubtitle('Season 2021.')
            ->addData([$incomeByDay, $incomeByWeek, $incomeByMonth])
            ->setLabels(['Today', 'This week', 'This month'])
            ->toVue();
    }
}
