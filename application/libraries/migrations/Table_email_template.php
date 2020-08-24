<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_email_template {
	/**
	 * !!! CAUTION !!!
	 * 
	 * Don't change the table name and class name because to important to seeder system
	 * 
	 * if you want to change the table name, copy your script code in this file
	 * remove this file with this bash 
	 * 
	 * php index.php Migration remove {table name}
	 * 
	 * then create new database with migration bash and paste you code before
	 */

	private $CI;

	public function __construct(){
		$this->CI =& get_instance();

        $this->CI->load->model('mc');
        $this->CI->load->library('Schema');
	}

	public function migrate(){
		$schema = $this->CI->schema->create_table('email_template');
        $schema->increments('tId', ['length' => '10']);
        $schema->string('tName');
        $schema->text('tEmail', ['type' => 'MEDIUMTEXT']);
        $schema->text('tEmailbak', ['type' => 'MEDIUMTEXT']);
        $schema->run();
	}

	public function seeder(){
		$arr = [
			['tId' => '1', 'tName' => 'Customer - Informasi Pembayaran', 'tEmail' => '<p>Bapak/Ibu {MEMBERNAME},</p>
		<p>Dengan Hormat, Kami menerima pesanan Anda dengan Nomor Invoice {INVOICE}.<br />------------------------------------------------------------<br />Silahkan lakukan pembayaran sebesar {GRANDTOTAL} ke salah satu metode pembayaran dari kami:</p>
		<p>{PAYMENT}<br />------------------------------------------------------------</p>
		<p>Detail pesanan Anda dapat dilihat dibagian bawah email ini atau silahkan masuk ke akun Anda.</p>
		<p>Agar pesanan Anda dapat diproses dan dikirim lebih cepat, konfirmasikan pembayaran Anda via SMS/Email.<br />Anda dapat mengkonfirmasi pesanan pada situs {SITENAME}</p>
		<p>Kami harap Anda melakukan pembayaran sesuai dengan total Rp {GRANDTOTAL},- (tidak dibulatkan). Jika harus dibulatkan, informasikan kepada kami melalui SMS atau Email, atau tulis pada kolom berita nomor pesanan: {INVOICE} Pembayaran diterima paling lambat: {ORDEREXP}. Setelah pembayaran kami terima, pesanan Anda akan diproses dan kami kirimkan.</p>
		<p>DETAIL PESANAN:</p>
		<table style="width: 100%;" border="0">
		<tbody>
		<tr>
		<td style="width: 30%;">Nama Pemesan</td>
		<td style="text-align: center; width: 3%;">:</td>
		<td>{MEMBERNAME}</td>
		</tr>
		<tr>
		<td>Email</td>
		<td style="text-align: center;">:</td>
		<td>{MEMBEREMAIL}</td>
		</tr>
		<tr>
		<td>No. Handphone</td>
		<td style="text-align: center;">:</td>
		<td>{MEMBERPHONE}</td>
		</tr>
		<tr>
		<td>Tanggal Pesan</td>
		<td style="text-align: center;">:</td>
		<td>{ORDERDATE}</td>
		</tr>
		<tr>
		<td>Pesanan Anda</td>
		<td style="text-align: center;">:</td>
		<td>{ORDERDETAIL}</td>
		</tr>
		<tr>
		<td>Pesanan dikirimkan ke</td>
		<td style="text-align: center;">:</td>
		<td>{MEMBERRECNAME}<br />{MEMBERADDR}<br />{MEMBERTOWN}</td>
		</tr>
		<tr>
		<td>Metode Pengiriman</td>
		<td style="text-align: center;">:</td>
		<td>{SHIPMETHOD}</td>
		</tr>
		<tr>
		<td>Pesan Khusus</td>
		<td style="text-align: center;">:</td>
		<td>{MEMBERMSG}</td>
		</tr>
		<tr>
		<td>Rincian Biaya Subtotal</td>
		<td style="text-align: center;">:</td>
		<td>{SUBTOTAL}</td>
		</tr>
		<tr>
		<td>Pajak{TAX}</td>
		<td style="text-align: center;">:</td>
		<td>{TAXAMOUNT}</td>
		</tr>
		<tr>
		<td>Ongkos Kirim</td>
		<td style="text-align: center;">:</td>
		<td>{SHIPPRICE}</td>
		</tr>
		</tbody>
		</table>
		<hr />
		<table style="width: 100%;" border="0">
		<tbody>
		<tr>
		<td style="width: 30%;"><strong>TOTAL AKHIR</strong></td>
		<td style="text-align: center; width: 3%;">:</td>
		<td>{GRANDTOTAL}</td>
		</tr>
		</tbody>
		</table>
		<p>Terima Kasih telah berbelanja di {SITENAME}</p>
		<p>{SIGNATURE}</p>', 'tEmailbak' => '<p>Bapak/Ibu {MEMBERNAME},</p>
		
		<p>Dengan Hormat, Kami menerima pesanan Anda dengan Nomor Invoice {INVOICE}.<br />
		------------------------------------------------------------<br />
		Silahkan lakukan pembayaran sebesar {GRANDTOTAL} ke salah satu metode pembayaran dari kami:</p>
		
		<p>{PAYMENT}<br />
		------------------------------------------------------------</p>
		
		<p>Detail pesanan Anda dapat dilihat dibagian bawah email ini atau klik: <a href="{PAYMENTINFO}" target="_blank">{PAYMENTINFO}</a> Agar pesanan Anda dapat diproses dan dikirim lebih cepat, konfirmasikan pembayaran Anda via SMS/Email.<br />
		Anda dapat mengirim konfirmasi pesanan melalui link berikut: <a href="{ORDERCONFIRMATION}" target="_blank">{ORDERCONFIRMATION}</a><br />
		<br />
		Kami harap Anda melakukan pembayaran sesuai dengan total Rp {GRANDTOTAL},- (tidak dibulatkan). Jika harus dibulatkan, informasikan kepada kami melalui SMS atau Email, atau tulis pada kolom berita nomor pesanan: {INVOICE} Pembayaran diterima paling lambat: {ORDEREXP}. Setelah pembayaran kami terima, pesanan Anda akan diproses dan kami kirimkan. Nomor resi akan kami beritahukan via email setelah paket kami kirimkan agar dapat Anda lacak. Untuk membatalkan pesanan ini, silahkan mengunjungi tautan ini: <a href="{CANCELORDER}" target="_blank">{CANCELORDER}</a></p>
		
		<p>DETAIL PESANAN:</p>
		
		<table border="0" style="width:100%">
			<tbody>
				<tr>
					<td style="width:30%">Nama Pemesan</td>
					<td style="text-align:center; width:3%">:</td>
					<td>{MEMBERNAME}</td>
				</tr>
				<tr>
					<td>Email</td>
					<td style="text-align:center">:</td>
					<td>{MEMBEREMAIL}</td>
				</tr>
				<tr>
					<td>No. Handphone</td>
					<td style="text-align:center">:</td>
					<td>{MEMBERPHONE}</td>
				</tr>
				<tr>
					<td>Tanggal Pesan</td>
					<td style="text-align:center">:</td>
					<td>{ORDERDATE}</td>
				</tr>
				<tr>
					<td>Pesanan Anda</td>
					<td style="text-align:center">:</td>
					<td>{ORDERDETAIL}</td>
				</tr>
				<tr>
					<td>Pesanan dikirimkan ke</td>
					<td style="text-align:center">:</td>
					<td>{MEMBERRECNAME}<br />
					{MEMBERADDR}<br />
					{MEMBERTOWN}</td>
				</tr>
				<tr>
					<td>Metode Pengiriman</td>
					<td style="text-align:center">:</td>
					<td>{SHIPMETHOD}</td>
				</tr>
				<tr>
					<td>Pesan Khusus</td>
					<td style="text-align:center">:</td>
					<td>{MEMBERMSG}</td>
				</tr>
				<tr>
					<td>Rincian Biaya Subtotal</td>
					<td style="text-align:center">:</td>
					<td>{SUBTOTAL}</td>
				</tr>
				<tr>
					<td>Pajak ({TAX}%)</td>
					<td style="text-align:center">:</td>
					<td>{TAXAMOUNT}</td>
				</tr>
				<tr>
					<td>Ongkos Kirim</td>
					<td style="text-align:center">:</td>
					<td>{SHIPPRICE}</td>
				</tr>
			</tbody>
		</table>
		
		<hr />
		<table border="0" style="width:100%">
			<tbody>
				<tr>
					<td style="width:30%"><strong>TOTAL AKHIR</strong></td>
					<td style="text-align:center; width:3%">:</td>
					<td>{GRANDTOTAL}</td>
				</tr>
			</tbody>
		</table>
		
		<p>Terima Kasih telah berbelanja di {SITENAME}</p>
		
		<p>{SIGNATURE}</p>'],
			['tId' => '2', 'tName' => 'Order Reminder', 'tEmail' => '<p>Mr/Mrs/Miss {MEMBERNAME},<br />
		Dear Sir,<br />
		This email is a reminder of your order with an invoice number&nbsp;{INVOICE}.<br />
		&nbsp;------------------------------------------------------------<br />
		<br />
		Please make a payment of&nbsp;{GRANDTOTAL},- o one of the accounts:<br />
		<br />
		{STORERECNAME}<br />
		<br />
		------------------------------------------------------------<br />
		Your order details can be seen at the bottom of this email or click here:<br />
		{VERIFYCODE}<br />
		In order to your order can be processed and delivered faster, confirm your payment via SMS/Email.<br />
		Confirm yout order from the following link:<br />
		{ORDERCONFIRMATION}<br />
		We hope you make a payment according to the total {GRANDTOTAL} (unrounded).<br />
		If it should be rounded, please inform us via SMS or email, or write information coloumn at: {INVOICE}<br />
		<br />
		Payments received no later than: {ORDEREXP}<br />
		After we receive your payment, your order will be handling and we will send it .<br />
		Receipt number will be informed via email after we send the package so that you can tracking.<br />
		<br />
		<br />
		Thank you for shopping at {SITENAME}<br />
		<br />
		{SIGNATURE}</p>', 'tEmailbak' => '<p>Mr/Mrs/Miss {MEMBERNAME},<br />
		Dear Sir,<br />
		This email is a reminder of your order with an invoice number&nbsp;{INVOICE}.<br />
		&nbsp;------------------------------------------------------------<br />
		<br />
		Please make a payment of&nbsp;{GRANDTOTAL},- o one of the accounts:<br />
		<br />
		{STORERECNAME}<br />
		<br />
		------------------------------------------------------------<br />
		Your order details can be seen at the bottom of this email or click here:<br />
		{VERIFYCODE}<br />
		In order to your order can be processed and delivered faster, confirm your payment via SMS/Email.<br />
		Confirm yout order from the following link:<br />
		{ORDERCONFIRMATION}<br />
		We hope you make a payment according to the total {GRANDTOTAL} (unrounded).<br />
		If it should be rounded, please inform us via SMS or email, or write information coloumn at: {INVOICE}<br />
		<br />
		Payments received no later than: {ORDEREXP}<br />
		After we receive your payment, your order will be handling and we will send it .<br />
		Receipt number will be informed via email after we send the package so that you can tracking.<br />
		<br />
		<br />
		Thank you for shopping at {SITENAME}<br />
		<br />
		{SIGNATURE}</p>'],
			['tId' => '3', 'tName' => 'Order Status Unpaid', 'tEmail' => '<p>Bapak/Ibu {MEMBERNAME},<br />
		Dengan hormat,<br />
		<br />
		Kami ingin menginformasikan bahwa status order Anda untuk nomor faktur {INVOICE} telah kami ganti menjadi &quot;Belum Bayar&quot;.<br />
		Status telah kami ganti pada tanggal {CHECKRECDATE} dikarenakan beberapa alasan.<br />
		Silahkan hubungi kami untuk mengetahui informasi lebih lanjut.<br />
		<br />
		Terima kasih atas kepercayaan Anda pada {SITENAME} .<br />
		<br />
		{SIGNATURE}</p>', 'tEmailbak' => '<p>Bapak/Ibu {MEMBERNAME},<br />
		Dengan hormat,<br />
		<br />
		Kami ingin menginformasikan bahwa status order Anda untuk nomor faktur {INVOICE} telah kami ganti menjadi &quot;Belum Bayar&quot;.<br />
		Status telah kami ganti pada tanggal {CHECKRECDATE} dikarenakan beberapa alasan.<br />
		Silahkan hubungi kami untuk mengetahui informasi lebih lanjut.<br />
		<br />
		Terima kasih atas kepercayaan Anda pada {SITENAME} .<br />
		<br />
		{SIGNATURE}</p>'],
			['tId' => '4', 'tName' => 'Payment Received', 'tEmail' => '<p>Bapak/Ibu {MEMBERNAME},<br />
		Dengan hormat,<br />
		<br />
		Kami ingin menginformasikan bahwa pembayaran Anda untuk nomor faktur {INVOICE} ke rekening kami telah diterima dengan baik.<br />
		Pada tanggal {CHECKRECDATE} kami telah memeriksa rekening kami dan dengan ini memastikan pembayaran Anda sepenuhnya telah kami terima.<br />
		Saat ini kami tengah mempersiapkan produk yang Anda pesan dan akan sesegera mungkin kami kirimkan.<br />
		Jika pesanan Anda telah kami kirimkan, kami akan kembali mengirimkan email pemberitahuan.<br />
		<br />
		Terima kasih atas pembayaran yang Anda lakukan dan tentunya atas KEPERCAYAAN Anda pada {SITENAME} .<br />
		<br />
		{SIGNATURE}</p>', 'tEmailbak' => '<p>Bapak/Ibu {MEMBERNAME},<br />
		Dengan hormat,<br />
		<br />
		Kami ingin menginformasikan bahwa pembayaran Anda untuk nomor faktur {INVOICE} ke rekening kami telah diterima dengan baik.<br />
		Pada tanggal {CHECKRECDATE} kami telah memeriksa rekening kami dan dengan ini memastikan pembayaran Anda sepenuhnya telah kami terima.<br />
		Saat ini kami tengah mempersiapkan produk yang Anda pesan dan akan sesegera mungkin kami kirimkan.<br />
		Jika pesanan Anda telah kami kirimkan, kami akan kembali mengirimkan email pemberitahuan.<br />
		<br />
		Terima kasih atas pembayaran yang Anda lakukan dan tentunya atas KEPERCAYAAN Anda pada {SITENAME} .<br />
		<br />
		{SIGNATURE}</p>'],
			['tId' => '5', 'tName' => 'Package Delivery Information', 'tEmail' => '<p>Bapak/Ibu {MEMBERNAME},<br />
		Dengan hormat,<br />
		<br />
		Proses order Anda nomor faktur {INVOICE} telah selesai dan status order Anda telah menjadi &quot;Selesai&quot;.<br />
		<br />
		Terima kasih telah mempercayai kami sebagai langganan Anda untuk belanja di {SITENAME} .<br />
		<br />
		{SIGNATURE}</p>', 'tEmailbak' => '<p>Bapak/Ibu {MEMBERNAME},<br />
		Dengan hormat,<br />
		<br />
		Proses order Anda nomor faktur {INVOICE} telah selesai dan status order Anda telah menjadi &quot;Selesai&quot;.<br />
		<br />
		Terima kasih telah mempercayai kami sebagai langganan Anda untuk belanja di {SITENAME} .<br />
		<br />
		{SIGNATURE}</p>'],
			['tId' => '6', 'tName' => 'Order Kadaluarsa', 'tEmail' => '<p>Bapak/Ibu {MEMBERNAME},<br />
		Dengan hormat,<br />
		<br />
		Kami memberitahukan bahwa order Anda nomor faktur {INVOICE} telah kadaluarsa. silahkan periksa status order pada situs kami <a href="{SITEURL}">{SITEURL}</a><br />
		<br />
		Terima kasih telah mempercayai kami sebagai langganan Anda untuk belanja di {SITENAME} .<br />
		<br />
		{SIGNATURE}</p>', 'tEmailbak' => '<p>Bapak/Ibu {MEMBERNAME},<br />
		Dengan hormat,<br />
		<br />
		Kami memberitahukan bahwa order Anda nomor faktur {INVOICE} telah kadaluarsa. silahkan periksa status order pada situs kami <a href="{SITEURL}">{SITEURL}</a><br />
		<br />
		Terima kasih telah mempercayai kami sebagai langganan Anda untuk belanja di {SITENAME} .<br />
		<br />
		{SIGNATURE}</p>'],
			['tId' => '7', 'tName' => 'Order Delete', 'tEmail' => 'Mr/Mrs/Ms {MEMBERNAME}, <br />With Respect, <br /><br />We would like to inform that your order invoice number&nbsp;{INVOICE} has abort. The reason for cancellation due to one of the following reasons:<br />- You do not transfer until the payment due.<br />- Email data or the address you provide is invalid. <br />- You order two times or more.<br />-&nbsp;The other reason. <br /><br />You can order the products you ordered back to visit our website at&nbsp;{SITEURL} . <br />We beg your understanding on this matter and apologize if it has caused inconvenience. <br />Thank you for your attention.<br /><br /><br />{SIGNATURE}', 'tEmailbak' => 'Bapak/Ibu {MEMBERNAME},
		Dengan hormat,
		
		Kami ingin menginformasikan bahwa pesanan Anda dengan nomor invoice {INVOICE} telah kami batalkan.
		 Alasan pembatalan karena salah satu sebab berikut ini:
		
		 - Anda tidak melakukan transfer sampai batas waktu pembayaran.
		 - Data email atau alamat yang Anda berikan tidak valid.
		 - Anda memesan 2 kali atau lebih.
		 - Alasan lainnya.
		
		Anda dapat memesan kembali produk yang Anda pesan dengan mengunjungi website kami di {SITEURL}	.
		Kami memohon pengertian dari Bapak/Ibu atas hal ini dan memohon maaf jika telah menimbulkan ketidaknyamanan.
		Terima kasih atas perhatian Anda!
		
		{SIGNATURE}'],
			['tId' => '8', 'tName' => 'Order Shipped', 'tEmail' => '<p>Bapak/Ibu {MEMBERNAME},<br />
		Dengan hormat,<br />
		<br />
		Kami memberitahukan bahwa order Anda nomor faktur {INVOICE} telah dikirim. silahkan periksa status order Anda dengan login pada <a href="{SITEURL}">{SITEURL}</a><br />
		<br />
		Terima kasih telah mempercayai kami sebagai langganan Anda untuk belanja di {SITENAME} .<br />
		<br />
		{SIGNATURE}</p>', 'tEmailbak' => '<p>Bapak/Ibu {MEMBERNAME},<br />
		Dengan hormat,<br />
		<br />
		Kami memberitahukan bahwa order Anda nomor faktur {INVOICE} telah dikirim. silahkan periksa status order Anda dengan login pada <a href="{SITEURL}">{SITEURL}</a><br />
		<br />
		Terima kasih telah mempercayai kami sebagai langganan Anda untuk belanja di {SITENAME} .<br />
		<br />
		{SIGNATURE}</p>'],
			['tId' => '9', 'tName' => 'Payment Confirmation', 'tEmail' => 'The customer informs that a payment the following data have been paid: <br /><br />Number of Invoice : {INVOICE} <br />Nama : {MEMBERNAME} <br />Email : {MEMBEREMAIL} <br />Transfer To : {PAYMENTBANK} <br />Nominal : {TRANSFERAMOUNT} <br />Transfer Date : {TRANSFERDATE} <br /><br />Information: {NOTES} <br /><br /><br />{SIGNATURE}', 'tEmailbak' => 'The customer informs that a payment the following data have been paid: <br /><br />Number of Invoice : {INVOICE} <br />Nama : {MEMBERNAME} <br />Email : {MEMBEREMAIL} <br />Transfer To : {PAYMENTBANK} <br />Nominal : {TRANSFERAMOUNT} <br />Transfer Date : {TRANSFERDATE} <br /><br />Information: {NOTES} <br /><br /><br />{SIGNATURE}'],
			['tId' => '10', 'tName' => 'Customer - Verify Email Change', 'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px">
			<tbody>
				<tr>
					<td>{HEADER}</td>
				</tr>
				<tr>
					<td>
					<p>Dear Bapak/Ibu {MEMBERNAME},<br />
					<br />
					Anda telah melakukan permintaan perubahan alamat email anda di {SYSTEMNAME}.<br />
					Verify your email by clicking this link :<br />
					<br />
					{EMAILCHANGEVERIFYURL}<br />
					<br />
					(Copy and paste the link above into your browser if it can not click)<br />
					<br />
					Thank You.</p>
		
					<p><strong>Abaikan email ini jika anda tidak merasa melakukan aktifitas ini</strong>.</p>
					</td>
				</tr>
				<tr>
					<td>{SIGNATURE}</td>
				</tr>
			</tbody>
		</table>
		', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}</td>
		</tr>
		<tr>
		<td>Dear,<br /><br /><span lang="en">You have changed your email on </span>{SYSTEMNAME}. <br /> <span lang="en">Verify your email by clicking this link :</span><br /><br /> {EMAILCHANGEVERIFYURL} <br /><br />(<span lang="en">Copy and paste the link above into your browser if it can not click</span>) <br /><br /> Thank You.<br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '11', 'tName' => 'Member - Verifikasi Email (Welcome)', 'tEmail' => '<table style="width: 800px; height: 287px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr style="height: 22px;">
		<td style="height: 22px; width: 796px;">{SITELOGO}</td>
		</tr>
		<tr style="height: 243px;">
		<td style="height: 243px; width: 796px;">
		<p><br />Anda telah bergabung di {SITENAME}.<br />Silahkan verifikasi akun anda dengan meng-klik link dibawah ini agar anda dapat masuk ke sistem kami:<br /><br /><a href="http://warungkita/wk_admin2020/{VERIFYREG}">{VERIFYREG}</a><br /><br />(Copy dan paste link pada web browser jika tidak bisa diklik)</p>
		<p>Terima kasih.<br />&nbsp;</p>
		</td>
		</tr>
		<tr style="height: 22px;">
		<td style="height: 22px; width: 796px;">{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px; height: 287px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr style="height: 22px;">
		<td style="height: 22px; width: 796px;">{SITELOGO}</td>
		</tr>
		<tr style="height: 243px;">
		<td style="height: 243px; width: 796px;">
		<p><br />Anda telah bergabung di {SITENAME}.<br />Silahkan verifikasi akun anda dengan meng-klik link dibawah ini agar anda dapat masuk ke sistem kami:<br /><br /><a href="http://warungkita/wk_admin2020/{VERIFYREG}">{VERIFYREG}</a><br /><br />(Copy dan paste link pada web browser jika tidak bisa diklik)</p>
		<p>Terima kasih.<br />&nbsp;</p>
		</td>
		</tr>
		<tr style="height: 22px;">
		<td style="height: 22px; width: 796px;">{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '12', 'tName' => 'Customer - Reset Password', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}</td>
		</tr>
		<tr>
		<td>Mr/Mrs/Ms {CUSTOMERNAME}, <br /> With respect, <br /><br /> Your password has been successfully changed. <br /> From now on, you have to log in using your email and your new password. <br /><br /> Thank You. <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}</td>
		</tr>
		<tr>
		<td>Mr/Mrs/Ms {CUSTOMERNAME},<br /><span id="result_box" class="short_text" lang="en"><span class="hps">With</span> <span class="hps">respect</span></span>,<br /><br /> <span lang="en">Your password has been successfully changed.</span><br /><span lang="en">From now on, you have to log in using your email and your new password.</span><br /><br /> Thank You. <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '13', 'tName' => 'Customer - Selamat Datang (Admin)', 'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px">
			<tbody>
				<tr>
					<td>{HEADER}<br />
					&nbsp;</td>
				</tr>
				<tr>
					<td>Bapak/Ibu {MEMBERNAME},<br />
					<br />
					Terima kasih telah mendaftar di {SYSTEMNAME}.<br />
					Silahkan set password anda melalui link dibawah ini:<br />
					{FORGOTPASSWORDLINK}<br />
					<br />
					(copy link diatas ke browser jika tidak bisa di klik)<br />
					<br />
					&nbsp;</td>
				</tr>
				<tr>
					<td>{SIGNATURE}</td>
				</tr>
			</tbody>
		</table>
		', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>With respect, <br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Click the link below to login: <br /><br /> {FORGOTPASSWORDLINK} <br /><br /> (Copy and paste the link above into your browser if it can not click) <br /><br /> You can reset your password via FORGOT PASSWORD features. <br /><br /> Terima kasih. <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '14', 'tName' => 'Order Canceled', 'tEmail' => '<p>Bapak/Ibu {MEMBERNAME},<br />
		Dengan hormat,<br />
		<br />
		Kami memberitahukan bahwa order Anda nomor faktur {INVOICE} telah kami batalkan. silahkan periksa status order pada situs kami <a href="{SITEURL}">{SITEURL}</a><br />
		<br />
		Terima kasih telah mempercayai kami sebagai langganan Anda untuk belanja di {SITENAME} .<br />
		<br />
		{SIGNATURE}</p>', 'tEmailbak' => '<p>Bapak/Ibu {MEMBERNAME},<br />
		Dengan hormat,<br />
		<br />
		Kami memberitahukan bahwa order Anda nomor faktur {INVOICE} telah kami batalkan. silahkan periksa status order pada situs kami <a href="{SITEURL}">{SITEURL}</a><br />
		<br />
		Terima kasih telah mempercayai kami sebagai langganan Anda untuk belanja di {SITENAME} .<br />
		<br />
		{SIGNATURE}</p>'],
			['tId' => '15', 'tName' => 'Supplier - Welcome', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>With respect, <br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Click the link below to login: <br /><br /> {SUPPLIERFORGOTPASSWORDLINK} <br /><br /> (Copy and paste the link above into your browser if it can not click) <br /><br /> You can reset your password via FORGOT PASSWORD features. <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>With respect, <br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Click the link below to login: <br /><br /> {SUPPLIERFORGOTPASSWORDLINK} <br /><br /> (Copy and paste the link above into your browser if it can not click) <br /><br /> You can reset your password via FORGOT PASSWORD features. <br /><br /> Terima kasih. <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '16', 'tName' => 'Customer - Forgot Password', 'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px">
			<tbody>
				<tr>
					<td>{MAILHEADER}</td>
				</tr>
				<tr>
					<td>Bapak/Ibu {MEMBERNAME},<br />
					Dengan hormat,<br />
					<br />
					Anda atau orang lain telah melakukan permintaan reset password melalui fitur LUPA PASSWORD.<br />
					Jika anda ingin benar-benar melakukan reset password, klik link dibawah ini:<br />
					<br />
					{FORGOTPASSWORDLINK}<br />
					&nbsp;</td>
				</tr>
				<tr>
					<td>{SIGNATURE}</td>
				</tr>
			</tbody>
		</table>', 'tEmailbak' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px">
			<tbody>
				<tr>
					<td>{MAILHEADER}</td>
				</tr>
				<tr>
					<td>Bapak/Ibu {MEMBERNAME},<br />
					Dengan hormat,<br />
					<br />
					Anda atau orang lain telah melakukan permintaan reset password melalui fitur LUPA PASSWORD.<br />
					Jika anda ingin benar-benar melakukan reset password, klik link dibawah ini:<br />
					<br />
					{FORGOTPASSWORDLINK}<br />
					&nbsp;</td>
				</tr>
				<tr>
					<td>{SIGNATURE}</td>
				</tr>
			</tbody>
		</table>'],
			['tId' => '17', 'tName' => 'Order Failed', 'tEmail' => '<p>Bapak/Ibu {MEMBERNAME},<br />
		Dengan hormat,<br />
		<br />
		Kami memberitahukan bahwa order Anda nomor faktur {INVOICE} gagal. silahkan periksa status order pada situs kami <a href="{SITEURL}">{SITEURL}</a><br />
		<br />
		Terima kasih telah mempercayai kami sebagai langganan Anda untuk belanja di {SITENAME} .<br />
		<br />
		{SIGNATURE}</p>', 'tEmailbak' => '<p>Bapak/Ibu {MEMBERNAME},<br />
		Dengan hormat,<br />
		<br />
		Kami memberitahukan bahwa order Anda nomor faktur {INVOICE} gagal. silahkan periksa status order pada situs kami <a href="{SITEURL}">{SITEURL}</a><br />
		<br />
		Terima kasih telah mempercayai kami sebagai langganan Anda untuk belanja di {SITENAME} .<br />
		<br />
		{SIGNATURE}</p>'],
			['tId' => '18', 'tName' => 'Supplier - Forgot Password', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}</td>
		</tr>
		<tr>
		<td>Mr/Mrs/Ms {SUPPLIERNAME}, <br />With respect, <br /><br /> You or someone has done a request to reset the password through PASSWORD FORGOT facilities. <br /> Your old password has not been changed. If you want to do a reset, do the following: <br /><br /> {SUPPLIERFORGOTPASSWORDLINK} <br /><br /> If the link above does not work in clicking, please copy and paste the link into your browser. <br /><br /> This link will expire within 1 hour. Ignore this message if you did not have to do a password reset request. <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}</td>
		</tr>
		<tr>
		<td>Mr/Mrs/Ms {SUPPLIERNAME}, <br />With respect, <br /><br /> You or someone has done a request to reset the password through PASSWORD FORGOT facilities. <br /> Your old password has not been changed. If you want to do a reset, do the following: <br /><br /> {SUPPLIERFORGOTPASSWORDLINK} <br /><br /> If the link above does not work in clicking, please copy and paste the link into your browser. <br /><br /> This link will expire within 1 hour. Ignore this message if you did not have to do a password reset request. <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '19', 'tName' => 'Supplier - Verify Email Change', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}</td>
		</tr>
		<tr>
		<td>Dear,<br /><br /><span lang="en">You have changed your email on </span>{SYSTEMNAME}. <br /> <span lang="en">Verify your email by clicking this link :</span><br /><br /> {SUPPLIEREMAILCHANGEVERIFYURL} <br /><br />(<span lang="en">Copy and paste the link above into your browser if it can not click</span>) <br /><br /> Thank You.<br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}</td>
		</tr>
		<tr>
		<td>Dear,<br /><br /><span lang="en">You have changed your email on </span>{SYSTEMNAME}. <br /> <span lang="en">Verify your email by clicking this link :</span><br /><br /> {EMAILCHANGEVERIFYURL} <br /><br />(<span lang="en">Copy and paste the link above into your browser if it can not click</span>) <br /><br /> Thank You.<br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '20', 'tName' => 'Customer - Reset Password Sukses', 'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px">
			<tbody>
				<tr>
					<td>{HEADER}</td>
				</tr>
				<tr>
					<td>Bapak/Ibu {MEMBERNAME},<br />
					Dengan Hormat,<br />
					<br />
					Password anda sukses diganti.<br />
					Sekarang anda dapat login menggunakan password baru anda.<br />
					<br />
					Terima kasih.<br />
					&nbsp;</td>
				</tr>
				<tr>
					<td>{SIGNATURE}</td>
				</tr>
			</tbody>
		</table>
		', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}</td>
		</tr>
		<tr>
		<td>Bapak/Ibu {SUPPLIERNAME},<br />Dengan hormat,<br /><br /> Password anda telah berhasil diubah. <br /> Mulai saat ini, anda harus login menggunakan email dan password baru anda. Gunakan kembali fitur FORGOT PASSWORD jika anda kembali lupa password. <br /><br /> Terima kasih. <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '21', 'tName' => 'Supplier - Verify Email', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}</td>
		</tr>
		<tr>
		<td><span id="result_box" class="short_text" lang="en"><span class="hps">With</span> <span class="hps">respect</span></span>,<br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Verify your email by clicking this link : <br /><br /> {SUPPLIEREMAILVERIFYURL} <br /><br /> (<span lang="en">Copy and paste the link above into your browser if it can not click</span>) <br /><br /><span lang="en">This link will expire within 1 hour. You can request verification email on customer area.</span><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}</td>
		</tr>
		<tr>
		<td><span id="result_box" class="short_text" lang="en"><span class="hps">With</span> <span class="hps">respect</span></span>,<br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Verify your email by clicking this link : <br /><br /> {SUPPLIEREMAILVERIFYURL} <br /><br /> (<span lang="en">Copy and paste the link above into your browser if it can not click</span>) <br /><br /><span lang="en">This link will expire within 1 hour. You can request verification email on customer area.</span><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '22', 'tName' => 'Purchase Order Information to Supplier', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SUPPLIERNAME}, <br /><br /> You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {SUPPLIERAREALINK} <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SUPPLIERNAME}, <br /><br /> You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {SUPPLIERAREALINK} <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '23', 'tName' => 'Quotation Information to Owner', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SYSTEMNAME}, <br /><br /> You have a new quotation with article number {ARTICLENUMBER}.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SYSTEMNAME}, <br /><br /> You have a new quotation with article number {ARTICLENUMBER}.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '24', 'tName' => 'Customer - Receipt', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="5" align="center">
		<tbody>
		<tr>
		<td colspan="2" align="center">{HEADER}</td>
		</tr>
		<tr>
		<td colspan="2" align="center"><strong style="font-size: 24px;">RECEIPT</strong><br /><br /></td>
		</tr>
		<tr>
		<td valign="top" width="35%">Number</td>
		<td valign="top">:&nbsp;{KWITANSINUMBER}</td>
		</tr>
		<tr>
		<td valign="top">Received From</td>
		<td valign="top">:&nbsp;{MEMBERNAME}</td>
		</tr>
		<tr>
		<td valign="top">In Payment for</td>
		<td>:&nbsp;</td>
		</tr>
		<tr>
		<td colspan="2">{DETAILKWITANSI}</td>
		</tr>
		<tr>
		<td>Amount</td>
		<td>: {GRANDTOTAL}</td>
		</tr>
		<tr>
		<td colspan="2">&nbsp;<br /><br /><br /></td>
		</tr>
		<tr>
		<td colspan="2" align="left"><hr />
		<div style="font-size: 10px; color: #999999;">{ADDITIONALINFO}</div>
		</td>
		</tr>
		<tr>
		<td colspan="2" align="left">&nbsp;<br /><br />{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="5" align="center">
		<tbody>
		<tr>
		<td colspan="2" align="center">{HEADER}</td>
		</tr>
		<tr>
		<td colspan="2" align="center"><strong style="font-size: 24px;">RECEIPT</strong><br /><br /></td>
		</tr>
		<tr>
		<td valign="top" width="35%"><em>Number</em></td>
		<td valign="top">:&nbsp;{KWITANSINUMBER}</td>
		</tr>
		<tr>
		<td valign="top"><em>Received From</em></td>
		<td valign="top">:&nbsp;{MEMBERNAME}</td>
		</tr>
		<tr>
		<td valign="top"><em>The SUM of</em></td>
		<td>:&nbsp;<em>{TERBILANG} Rupiah</em></td>
		</tr>
		<tr>
		<td valign="top"><em>In Payment for</em></td>
		<td>:&nbsp;</td>
		</tr>
		<tr>
		<td colspan="2">{DETAILKWITANSI}</td>
		</tr>
		<tr>
		<td><em>Amount</em></td>
		<td>:&nbsp;Rp {GRANDTOTAL}</td>
		</tr>
		<tr>
		<td colspan="2">&nbsp;<br /><br /><br /></td>
		</tr>
		<tr>
		<td colspan="2" align="left"><hr />
		<div style="font-size: 10px; color: #999999;">{PAYMENTINFO}</div>
		</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '25', 'tName' => 'Order Delete Info', 'tEmail' => '<p>Bapak/Ibu {MEMBERNAME},<br />
		Dengan hormat,<br />
		<br />
		Kami ingin menginformasikan bahwa order Anda untuk nomor faktur {INVOICE} telah kami hapus secara permanen.<br />
		Silahkan hubungi kami untuk mengetahui informasi lebih lanjut.<br />
		<br />
		Terima kasih atas kepercayaan Anda pada {SITENAME} .<br />
		<br />
		{SIGNATURE}</p>', 'tEmailbak' => '<p>Bapak/Ibu {MEMBERNAME},<br />
		Dengan hormat,<br />
		<br />
		Kami ingin menginformasikan bahwa order Anda untuk nomor faktur {INVOICE} telah hapus permanen.<br />
		Silahkan hubungi kami untuk mengetahui informasi lebih lanjut.<br />
		<br />
		Terima kasih atas kepercayaan Anda pada {SITENAME} .<br />
		<br />
		{SIGNATURE}</p>'],
			['tId' => '26', 'tName' => 'Re-Order PO Information', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SUPPLIERNAME}, <br /><br /> You have re-order PO with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SUPPLIERNAME}, <br /><br /> You have re-order PO with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '27', 'tName' => 'Purchase Order Has Been Revised to Supplier', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SUPPLIERNAME}, <br /><br />Purchase order has been revised by Owner with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {SUPPLIERAREALINK} <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SUPPLIERNAME}, <br /><br />Purchase order has been revised by Owner with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {SUPPLIERAREALINK} <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '28', 'tName' => 'Purchase Order Has Been Revised to Owner', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SYSTEMNAME}, <br /><br />Purchase order has been revised by Owner with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {ADMINAREALINK} <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SYSTEMNAME}, <br /><br />Purchase order has been revised by Owner with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {ADMINAREALINK} <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '29', 'tName' => 'Owner - New Custom Design Information', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SYSTEMNAME}, <br /><br /> You have a new custom design from customer with design name <strong>{DESIGNNAME}</strong>.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SYSTEMNAME}, <br /><br /> You have a new design from customer with design name {DESIGNNAME}.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '30', 'tName' => 'Supplier - New Design Information', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name <strong>{DESIGNNAME}</strong>.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '31', 'tName' => 'Reminder of approval new PO to Supplier', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SUPPLIERNAME}, <br /><br />We reminded You that You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SUPPLIERNAME}, <br /><br />We reminded You that You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '32', 'tName' => 'Reminder of approval new PO to Owner', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SYSTEMNAME}, <br /><br />The system reminded You that You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {ADMINAREALINK} <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SYSTEMNAME}, <br /><br />The system reminded You that You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {ADMINAREALINK} <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '33', 'tName' => 'Supplier - Approve New Design', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SYSTEMNAME}, <br /><br /> You have an <strong>approved</strong> new design from {MEMBERNAME} with design name <strong>{DESIGNNAME}</strong>.<br />Please check your admin area: <br /><br /> {ADMINAREALINK} <br /><br />thank you.<br /><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '34', 'tName' => 'Supplier - Sending New Design', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SYSTEMNAME}, <br /><br /> Your new design&nbsp;<strong>{DESIGNNAME}</strong> has been sending by {MEMBERNAME}.<strong><br /><br /></strong>Please check your admin area: <br /><br /> {ADMINAREALINK} <br /><br />thank you.<br /><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '35', 'tName' => 'Owner - Custom Design Deleted By Customer', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SYSTEMNAME}, <br /><br /> One of a new custom design has been canceled by each customer with design name <strong>{DESIGNNAME}</strong>.<br /><br />Thank You.<br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SYSTEMNAME}, <br /><br /> You have a new design from customer with design name {DESIGNNAME}.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '36', 'tName' => 'Owner - Pembayaran Order Poin Diterima', 'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px">
			<tbody>
				<tr>
					<td>{HEADER}<br />
					&nbsp;</td>
				</tr>
				<tr>
					<td>
					<p>Yang Terhormat {MEMBERNAME},<br />
					<br />
					Kami telah menerima pembayaran atas pesanan <strong>POIN</strong> anda dengan nomor invoice: #{INVOICE}</p>
		
					<p>Secara otomaris poin anda telah ditambahkan.<br />
					<br />
					Terima kasih.<br />
					<br />
					&nbsp;</p>
					</td>
				</tr>
				<tr>
					<td>{SIGNATURE}</td>
				</tr>
			</tbody>
		</table>
		', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '38', 'tName' => 'Supplier - Notification for create PO from Quotation', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SUPPLIERNAME}, <br /><br />We reminded You, that You have a new purchase order ({ARTICLENUMBER}) from quotation ({ARTICLENUMBER2}).<br /><br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SUPPLIERNAME}, <br /><br />We reminded You, that You have a new purchase order ({ARTICLENUMBER}) from quotation ({ARTICLENUMBER2}).<br /><br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '41', 'tName' => 'Owner - Inactive Customer', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SYSTEMNAME}, <br /><br /> Customer with customer code {MEMBERCODE} and customer name {MEMBERNAME} is in active. Because he did not shop more than 1 month<br /><br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SYSTEMNAME}, <br /><br /> Customer with customer code {MEMBERCODE} and customer name {MEMBERNAME} is in active. Because he did not shop more than 1 month<br /><br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '44', 'tName' => 'Owner - Customer is not Spending More than 2 Weeks', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SYSTEMNAME}, <br /><br /> Customer with customer code {MEMBERCODE} and customer name {MEMBERNAME} did not shop more than 2 weeks.<br /><br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {SYSTEMNAME}, <br /><br /> Customer with customer code {MEMBERCODE} and customer name {MEMBERNAME} did not shop more than 2 weeks.<br /><br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '45', 'tName' => 'Owner - Quotation request from new design', 'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {MEMBERNAME}, <br /><br /> You have an <strong>requested</strong> quotation of new design from {SYSTEMNAME} with design name <strong>{DESIGNNAME}</strong>.<br />Please check your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br />thank you.<br /><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>', 'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr>
		<td align="center">{HEADER}<br /><br /></td>
		</tr>
		<tr>
		<td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td>
		</tr>
		<tr>
		<td>{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'],
			['tId' => '46', 'tName' => 'Coba Email Template', 'tEmail' => '<p>Assalamualaikum Wr Wb Yaa</p>', 'tEmailbak' => '<p>Assalamualaikum Wr Wb</p>
		'],
			['tId' => '47', 'tName' => 'Email Customer Baru Dari Facebook', 'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px">
			<tbody>
				<tr>
					<td>{HEADER}<br />
					&nbsp;</td>
				</tr>
				<tr>
					<td>Bapak/Ibu {MEMBERNAME},<br />
					<br />
					Terima kasih telah mendaftar di {SYSTEMNAME}.<br />
					Kami senang Anda telah bergabung bersama kami. silahkan pilih menu masakan lezat dari kami<br />
					<br />
					&nbsp;</td>
				</tr>
				<tr>
					<td>{SIGNATURE}</td>
				</tr>
			</tbody>
		</table>
		', 'tEmailbak' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px">
			<tbody>
				<tr>
					<td>{HEADER}<br />
					&nbsp;</td>
				</tr>
				<tr>
					<td>Bapak/Ibu {MEMBERNAME},<br />
					<br />
					Terima kasih telah mendaftar di {SYSTEMNAME}.<br />
					Kami senang Anda telah bergabung bersama kami. silahkan pilih menu masakan lezat dari kami<br />
					<br />
					&nbsp;</td>
				</tr>
				<tr>
					<td>{SIGNATURE}</td>
				</tr>
			</tbody>
		</table>
		'],
			['tId' => '48', 'tName' => 'Pemberitahuan Pesan Baru', 'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px">
			<tbody>
				<tr>
					<td>{HEADER}</td>
				</tr>
				<tr>
					<td>
					<p>Bapak/Ibu {MEMBERNAME},<br />
					Dengan hormat,<br />
					<br />
					Anda menerima pesan baru dari {SENDER}, cek segera siapa tahu ada rezeki dari allah :)<br />
					&nbsp;</p>
		
					<p><a href="{INBOXANSWERLINK}"><input name="Balas" type="button" value="Balas" /></a></p>
					</td>
				</tr>
				<tr>
					<td>{SIGNATURE}</td>
				</tr>
			</tbody>
		</table>
		', 'tEmailbak' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px">
			<tbody>
				<tr>
					<td>{HEADER}</td>
				</tr>
				<tr>
					<td>
					<p>Bapak/Ibu {MEMBERNAME},<br />
					Dengan hormat,<br />
					<br />
					Anda menerima pesan baru dari {SENDER}, cek segera siapa tahu ada rezeki dari allah :)<br />
					&nbsp;</p>
		
					<p><input name="Balas" type="button" value="Balas" /></p>
					</td>
				</tr>
				<tr>
					<td>{SIGNATURE}</td>
				</tr>
			</tbody>
		</table>
		'],
		];
		return $arr;
	}

}

