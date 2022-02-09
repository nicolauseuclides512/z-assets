<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAssetBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_banks', function (Blueprint $table) {
            $table->string('full_name', 100)->nullable();
        });

        DB::Transaction(function () {
            DB::update("UPDATE asset_banks SET name='BCA',
                        logo='https://s3-ap-southeast-1.amazonaws.com/asset.zuragan.com.dev/assets/banks/bank_bca.png',
                        full_name='BANK CENTRAL ASIA (BCA)', status=true WHERE id=1");
            DB::update("UPDATE asset_banks SET name='BRI',
                        logo='https://s3-ap-southeast-1.amazonaws.com/asset.zuragan.com.dev/assets/banks/bank_bri.png',
                        full_name='BANK RAKYAT INDONESIA (BRI)', status=true WHERE id=2");
            DB::update("UPDATE asset_banks SET name='Mandiri',
                        logo='https://s3-ap-southeast-1.amazonaws.com/asset.zuragan.com.dev/assets/banks/bank_mandiri.png',
                        full_name='BANK MANDIRI (PERSERO)', status=true WHERE id=3");
            DB::update("UPDATE asset_banks SET name='BNI',
                        logo='https://s3-ap-southeast-1.amazonaws.com/asset.zuragan.com.dev/assets/banks/bank_bni.png',
                        full_name='BANK NEGARA INDONESIA (BNI)', status=true WHERE id=5");
            DB::update("UPDATE asset_banks SET name='MEGA',
                        logo='https://s3-ap-southeast-1.amazonaws.com/asset.zuragan.com.dev/assets/banks/bank_mega.png',
                        full_name='BANK MEGA', status=true WHERE id=9");
            DB::update("UPDATE asset_banks SET name='CIMB NIAGA',
                        logo='https://s3-ap-southeast-1.amazonaws.com/asset.zuragan.com.dev/assets/banks/bank_cimb.png',
                        full_name='PT. BANK CIMB NIAGA', status=true WHERE id=15");
            DB::update("UPDATE asset_banks SET name='PERMATA',
                        logo='https://s3-ap-southeast-1.amazonaws.com/asset.zuragan.com.dev/assets/banks/bank_permata.png',
                        full_name='PT. BANK PERMATA', status=true WHERE id=52");
            DB::update("UPDATE asset_banks SET name='DANAMON',
                        logo='https://s3-ap-southeast-1.amazonaws.com/asset.zuragan.com.dev/assets/banks/bank_danamon.png',
                        full_name='PT. BANK DANAMON INDONESIA', status=true WHERE id=57");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK SYARIAH MANDIRI', status=false WHERE id=4");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK PANIN', status=false WHERE id=6");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK BUKOPIN', status=false WHERE id=7");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK INDONESIA (BI)', status=false WHERE id=8");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK SYARIAH MEGA INDONESIA', status=false WHERE id=10");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='CITIBANK, N.A.', status=false WHERE id=11");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK SYARIAH MUAMALAT INDONESIA', status=false WHERE id=12");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK SINARMAS', status=false WHERE id=13");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK INTERNASIONAL INDONESIA  (EXPEND CONTROL DEPT.)', status=false WHERE id=14");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='ABN AMRO BANK N.V.', status=false WHERE id=16");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANGKOK BANK PUBLIC COMPANY LIMITED', status=false WHERE id=17");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK ARTHA GRAHA INTERNASIONAL TBK', status=false WHERE id=18");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK BNP PARIBAS INDONESIA', status=false WHERE id=19");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK BUMIPUTERA INDONESIA', status=false WHERE id=20");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK CHINATRUST INDONESIA', status=false WHERE id=21");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK COMMONWEALTH', status=false WHERE id=22");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK DBS INDONESIA', status=false WHERE id=23");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK DKI', status=false WHERE id=24");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK EKONOMI RAHARJA', status=false WHERE id=25");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK EKSPOR INDONESIA (PERSERO)', status=false WHERE id=26");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK FINCONESIA', status=false WHERE id=27");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK GANESHA', status=false WHERE id=28");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK KESAWAN', status=false WHERE id=29");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK MAYBANK INDOCORP', status=false WHERE id=30");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK MIZUHO INDONESIA', status=false WHERE id=31");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK OCBC INDONESIA', status=false WHERE id=32");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK OF AMERICA, N.A.', status=false WHERE id=33");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK OF CHINA', status=false WHERE id=34");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK OF TOKYO-MITSUBISHI UFJ, LTD.', status=false WHERE id=35");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK RABOBANK INTERNATIONAL INDONESIA', status=false WHERE id=36");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK RESONA PERDANIA', status=false WHERE id=37");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK SUMITOMO MITSUI INDONESIA', status=false WHERE id=38");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK SWADESI', status=false WHERE id=39");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK TABUNGAN NEGARA', status=false WHERE id=40");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='BANK UOB INDONESIA', status=false WHERE id=41");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='DEUTSCHE BANK AG  (DBJK INVESTMENT BANKING OPS)', status=false WHERE id=42");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='HONGKONG AND SHANGHAI BANKING CORPORATION LIMITED', status=false WHERE id=43");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='JPMORGAN CHASE BANK, N.A.  (TELEX AND S.W.I.F.T. MESSAGE ENQUIRIES)', status=false WHERE id=44");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='KUSTODIAN SENTRAL EFEK INDONESIA PT', status=false WHERE id=45");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='PT. BANK KEB INDONESIA', status=false WHERE id=46");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='PT. MERCEDES-BENZ DISTRIBUTION INDONESIA', status=false WHERE id=47");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='PAN INDONESIA BANK', status=false WHERE id=48");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='PT. BANK BUMI ARTA TBK', status=false WHERE id=49");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='PT. BANK ICBC INDONESIA', status=false WHERE id=50");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='PT. BANK OCBC NISP TBK', status=false WHERE id=51");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='PT. BANK UOB BUANA', status=false WHERE id=53");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='PT. CREDIT SUISSE INVESTMENT MANAGEMENT INDONESIA', status=false WHERE id=54");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='PT. BANK AGRONIAGA TBK', status=false WHERE id=55");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='PT. BANK CENTURY TBK', status=false WHERE id=56");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='PT. BANK HANA', status=false WHERE id=58");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='PT. BANK HIMPUNAN SAUDARA 1906, TBK', status=false WHERE id=59");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='PT. BANK JATIM', status=false WHERE id=60");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='PT. BANK MAYAPADA INTERNATIONAL TBK', status=false WHERE id=61");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='PT. BANK PEMBANGUNAN DAERAH BALI', status=false WHERE id=62");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='PT. BANK PEMBANGUNAN DAERAH SUMATERA SELATAN', status=false WHERE id=63");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='STANDARD CHARTERED BANK', status=false WHERE id=64");
            DB::update("UPDATE asset_banks SET name=null,
                        logo=null,
                        full_name='WOORI BANK, INDONESIA', status=false WHERE id=65");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
