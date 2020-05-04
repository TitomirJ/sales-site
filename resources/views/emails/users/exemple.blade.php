
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		@font-face {font-family:'Montserrat Alternates';src:url(MontserratAlternates-Regular.ttf) format("truetype");font-weight: normal;}
		@font-face {font-family:'Montserrat Alternates';src:url(MontserratAlternates-Light.ttf) format("truetype");font-weight: 300;}
		body {margin:0;padding:0;box-sizing:border-box;font-family:'Montserrat Alternates'}
		td {padding:0 37px}
		a{text-decoration:none}
	</style>
</head>
<body style="background: #e9e9e9">

	<table width="100%" cellspacing="0" cellpadding="0" border="0" style="overflow: hidden;">

		<tr>
			<td align="center" style="overflow: hidden;">
				<table width="600" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;overflow: hidden;">
					<tr>
						<td height="222" width="100%" style="background-image: url(top.png); margin-left: -5px;transform: scale(1.05)"></td>
					</tr>
				</table>
				<table width="600" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;background:#e9e9e9;margin-top:-12px">
					<tr>
						<td align="center" style="padding-top:30px;font-size:20px">Вы зарегистрировались на BigSales!</td>
					</tr>
					<tr align="center">
						<td height="2">
							<div style="border-bottom:2px solid #cacaca;width:500px"></div>
						</td>
					</tr>
					<tr>
						<td style="padding:27px 37px;font-size: 18px;text-transform: uppercase">
							<span>
								данные для входа:
							</span>
						</td>
					</tr>
					<tr>
						<td>
							Адрес электронной почты: {{ $user->email }}
						</td>
					</tr>
					<tr>
						<td style="padding: 10px 37px 30px">
							Пароль: {{ $password }}
						</td>
					</tr>
				</table>
				<table width="600" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;background:#3f4666;box-shadow: 0px 0px 20px inset #181818;">
					<tr>
						<td style="padding: 37px; color:#fff">
							<div style="padding-bottom: 10px;font-size:14px">1. Всегда храните свои данные в безопасности.</div>
							<div style="padding-bottom: 10px;font-size:14px">2. Никогда не передавайте никому свои данные для входа.</div>

							<div style="padding-bottom: 10px;font-size:14px">3. Регулярно меняйте пароль.</div>

							<div style="font-size:14px">4. Если вы подозреваете, что кто-то использует вашу учетную запись незаконно, пожалуйста, немедленно сообщите нам.</div>
						</td>
					</tr>
				</table>
				<table width="600" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;background:#839ac3">
					<tr>
						<td style="padding: 37px; color:#fff">
							<div style="font-size:18px;text-transform:uppercase;text-align:center;font-weight: 600;">наши контакты</div>
						</td>
					</tr>
				</table>
				<table width="600" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;background:#434a6b">
					<tr>
						<td style="padding: 27px 37px; color:#fff;">
							<div style="font-size:15px;font-weight: 600;padding-bottom: 10px">Телефоны: <span style="font-weight: 300">067 666 54 66; 066 666 54 86</span></div>
							<div style="font-size:15px;font-weight: 600;">Электронная почта: <span style="font-weight: 300">support@peace-it.info</span></div>
						</td>
					</tr>
				</table>
				<table width="600" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;background:#839ac3">
					<tr>
						<td style="color:#fff">
							<div style="font-size:30px;text-align:center;font-weight:600; padding: 20px">
								<a href="#">
									<img src="icons/face.png" alt="facebook">
								</a>
								<a href="#" style="padding: 0 10px">
									<img src="icons/insta.png" alt="instagram">
								</a>
								<a href="#">
									<img src="icons/youtube.png" alt="youtube">
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
