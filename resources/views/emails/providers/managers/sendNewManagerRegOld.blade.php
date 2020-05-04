<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Вы зарегистрированы!</title>
	<style>
		body {margin:0;padding:0;box-sizing:border-box;font-family:cursive;}
		td {padding:0 37px}
		a{text-decoration:none;color:#000}
	</style>
</head>
<body>

	<table width="100%" cellspacing="0" cellpadding="0" border="0" style="overflow: hidden;">

		<tr>
			<td align="center" style="overflow: hidden;">
				<table width="600" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;overflow: hidden;">
					<tr>
						<td height="222" width="100%" style="background-image: url({{asset('/public/images/top-man.png')}}); margin-left: -5px;transform: scale(1.05);background-size: 104%;background-position: bottom;"></td>
					</tr>
				</table>
				<table width="600" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;background:#e9e9e9;margin-top:-12px">
					<tr>
						<td align="center" style="padding-top:30px;font-size:20px">
							Вы зарегистрированы как менеджер!
						</td>
					</tr>
					<tr align="center">
						<td height="2">
							<div style="border-bottom:2px solid #cacaca;width:500px"></div>
						</td>
					</tr>
					<tr>
						<td style="font-size:18px;padding-top: 15px">
							Вас пригласил {{$director->getFullName() .', директор компании '. $company->name}}
						</td>
					</tr>
					<tr>
						<td style="padding:27px 37px;font-size: 20px">
              Ваша почта: {{ $user->email }}<br>
              Ваш пароль: {{ $password }}
						</td>
					</tr>
					<tr>
						<td style="padding: 10px 37px; font-size:18px;text-align: right">
							С уважением,<br>
							команда BigSales
						</td>
					</tr>
				</table>
				<table width="600" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;background:#3f4666;box-shadow: 0px 0px 20px inset #181818;">
          <tr>
						<td style="padding: 37px; color:#fff">
							<div style="padding-bottom: 10px;font-size:18px">1. Всегда храните свои данные в безопасности.</div>
							<div style="padding-bottom: 10px;font-size:18px">2. Никогда не передавайте никому свои данные для входа.</div>

							<div style="padding-bottom: 10px;font-size:18px">3. Регулярно меняйте пароль.</div>

							<div style="font-size:18px">4. Если вы подозреваете, что кто-то использует вашу учетную запись незаконно, пожалуйста, немедленно сообщите нам.</div>
						</td>
					</tr>
				</table>
				<table width="600" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;background:#839ac3">
					<tr>
						<td style="padding: 37px; color:#fff">
							<div style="font-size:25px;text-transform:uppercase;text-align:center;font-weight: 600;">наши контакты</div>
						</td>
					</tr>
				</table>
				<table width="600" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;background:#434a6b">
					<tr>
						<td style="padding: 27px 37px; color:#fff;">
							<div style="font-size:18px;font-weight: 600;padding-bottom: 10px">Телефоны: <a href="tel:067 666 54 66" style="font-weight: 300;color:#fff">067 666 54 66;<a href="tel:066 666 54 86" style="font-weight: 300;color:#fff">066 666 54 86</a></div>
							<div style="font-size:18px;font-weight: 600;">Электронная почта: <a href="mailto:support@peace-it.info" style="font-weight: 300;color:#fff">support@peace-it.info</a></div>
						</td>
					</tr>
				</table>
				<table width="600" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;background:#839ac3">
					<tr>
						<td style="color:#fff">
							<div style="font-size:30px;text-align:center;font-weight:600;padding:20px">
								<a href="https://www.facebook.com/bigsalespro">
									<img src="{{asset('/public/images/face.png')}}" alt="facebook">
								</a>
								<a href="https://www.instagram.com/_bigsales.pro_/?hl=ru" style="padding: 0 10px">
									<img src="{{asset('/public/images/insta.png')}}" alt="instagram">
								</a>
								<a href="https://www.youtube.com/channel/UCFtNu_9QMoXOhc1g_jApaHw?view_as=subscriber">
									<img src="{{asset('/public/images/youtube.png')}}" alt="youtube">
								</a>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>

	</table>

</body>
</html>
