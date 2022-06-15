

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Country Synergy | Invoice</title>

		<style>
			.invoice-box {
				max-width: 1024px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: center;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			/* .invoice-box table tr td:nth-child(2) {
				text-align: right;
			} */

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
				text-align:left;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
			.addr1 {
				text-align: left;
			}
			.addr2 {
				text-align: right;
			}
			.title2 {
				text-align:right;
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="3">
						<table>
							<tr>
								<td class="title">
									<img src="img/Country-Synergy-Logo.png" style="width: 100%; max-width: 300px" />
								</td>

								<td class="title2">
									Invoice #: 123<br />
									Created: June 14, 2022<br />
									Due: July 15, 2022
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="3">
						<table>
							<tr>
								<td class="addr1">
                                    
									Country Synergy.<br />
									25 Ruthven St, <br />
									Harlaxton, QLD 4350
								</td>
                                
								<td class="addr2">
                                    <b>Deliver to:</b><br/>
									Acme Corp.<br />
									John Doe<br />
									john@example.com
								</td>
							</tr>
						</table>
					</td>
				</tr>

			

				<tr class="heading" colspan="3">
					<td>PLU</td>
                    <td>Description</td>
					<td>Price</td>
                    
				</tr>

                <!----------------------- Start Foreach Here ---------------------->
				<tr class="item" colspan="3">
					<td>385</td>
                    <td>Drumstick (First Grade, Bulk)</td>
					<td>$3.00 / kg</td>
				</tr>

				<tr class="item" colspan="3">
					<td>1008</td>
                    <td>Frozen XL Bird</td>
					<td>$11.74</td>
				</tr>

				<tr class="item last" colspan="3">
					<td>1010</td>
                    <td>Frozen Whole Bird</td>
					<td>$11.74</td>
				</tr>
				
				<tr class="total" colspan="3">
					<td></td>
                    <td></td>
					<td><b>Total: $385.00</b></td>
				</tr>
                <!----------------------- End of Foreach Here ---------------------->
			</table>
		</div>
	</body>
</html>