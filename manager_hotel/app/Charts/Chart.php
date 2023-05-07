<?php

namespace App\Charts;

use App\Repositories\Eloquent\BookingRepository;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class Chart
{
    protected $chart;
    protected $bookingRepository;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
        $this->bookingRepository = app(BookingRepository::class);
    }

    public function build(): array
    {
        $incomeByDay = $this->bookingRepository->getTotalMoneyByDay();
        $incomeByWeek = $this->bookingRepository->getTotalMoneyByWeek();
        $incomeByMonth = $this->bookingRepository->getTotalMoneyByMonth();
        $incomeByYear = $this->bookingRepository->getTotalMoneyByYear();
        return $this->chart->lineChart()
            ->setTitle('Sales during 2021.')
            ->setSubtitle('Physical sales vs Digital sales.')
            ->addData('Physical sales', [40, 93, 35, 42, 18, 82])
            ->addData('Digital sales', [70, 29, 77, 28, 55, 45])
            ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June'])
            ->toVue();
    }
}
