<?php

namespace Tests\Unit;

use App\Services\Error;
use App\Services\Kendaraan\Models\Kendaraan;
use PHPUnit\Framework\TestCase;

use App\Services\Transaksi\Interfaces\Repositories\Transaksi as TransaksiRepo;
use App\Services\Kendaraan\Interfaces\Repositories\Kendaraan as KendaraanRepo;

use App\Services\Transaksi\Models\Transaksi as TransaksiModel;
use App\Services\Transaksi\Models\TransaksiDetail as TransaksiDetailModel;
use App\Services\Transaksi\Models\TransaksiKendaraanReport;
use App\Services\Transaksi\Service as TransaksiService;
use stdClass;

class TransaksiTest extends TestCase
{
    protected $transaksiRepoMock;
    protected $kendaraanRepoMock;
    protected $transaksiService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transaksiRepoMock = $this->createMock(TransaksiRepo::class);
        $this->kendaraanRepoMock = $this->createMock(KendaraanRepo::class);

        $this->transaksiService = new TransaksiService($this->transaksiRepoMock, $this->kendaraanRepoMock);
    }

    public function testInsertTransactionWithValidData()
    {
        $transaksi = new TransaksiModel('', now(), 0, '', '');

        $transaksiDetail = [
            new TransaksiDetailModel('',0,0,'',''),
            new TransaksiDetailModel('',0,0,'',''),
        ];

        $this->transaksiRepoMock
            ->expects($this->once())
            ->method('insertTransaction')
            ->willReturn(new TransaksiModel('', now(), 0, '', ''));

        $this->transaksiRepoMock
            ->expects($this->exactly(count($transaksiDetail)))
            ->method('insertTransactionDetails')
            ->willReturn(new TransaksiDetailModel('',0,0,'',''));

        $this->kendaraanRepoMock
            ->expects($this->exactly(count($transaksiDetail)))
            ->method('getByID')
            ->willReturn(new Kendaraan('','','',0,'',0,0));

        $this->kendaraanRepoMock
            ->expects($this->exactly(count($transaksiDetail)))
            ->method('addStock')
            ->willReturn(true);

        $error = $this->transaksiService->insertTransaction($transaksi, $transaksiDetail);

        $this->assertNull($error);
    }

    public function testInsertTransactionWithWrongDetailInstance()
    {
        $transaksi = new TransaksiModel('', now(), 0, '', '');
        $transaksi->transaction_number = '';
        $transaksi->transaction_date = now();

        $transaksiDetail = [
            new stdClass(), // Wrong instance
        ];

        $error = $this->transaksiService->insertTransaction($transaksi, $transaksiDetail);

        $this->assertInstanceOf(Error::class, $error);
        $this->assertEquals('wrong detail instance', $error->e->getMessage());
    }
}
