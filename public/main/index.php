<!DOCTYPE html>
<html>

<head>
	<title>Booking Form</title>
	<link rel="stylesheet" type="text/css" href="./index.css">
</head>

<body>
	<style>
		body {
			background-color: rgb(253, 229, 255);
		}

		nav {
			background-color: rgb(252, 243, 253);
			width: 100%;
			height: 80px;
			position: sticky;
			margin: auto;
			z-index: 1;
			display: flex;
			align-items: center;
		}

		.nav-links {
			flex: 1;
			text-align: center;
		}

		.nav-links ul li {
			list-style: none;
			display: inline-block;
			margin: 0 20px;
		}

		.nav-links ul li a {
			color: rgb(114, 49, 175);
			text-decoration: none;
		}

		.form-row button[type="submit"] {
			background-color: rgb(230, 95, 174);
		}
	</style>
	<div class="nav-links">
		<ul>
			<li><a href="">Home</a></li>
			<li><a href="../index.html">About</a></li>
			<li><a href="../index.html">Contact us</a></li>
			<li><a href="../pages/sevices.html"> Services </a></li>
			<li>
				<button class="login btn btn-outline-info" onclick="window.location.href = '../main/view_bookings.php';">
					View bookings </button>
			</li>
			<li>
				<button class="login btn btn-outline-info" onclick="window.location.href = '../index.html';">
					logout </button>
			</li>
			<li class="scroll-to-section"><a href="#" id="our-location"><?php
																		if (isset($_SESSION['username'])) {
																			echo "" . $_SESSION['username'];
																		}
																		?></a></li>
		</ul>
	</div>
	<div class="form-container">
		<form method="post" action="appointments.php">
			<div class="form-row">
				<div class="form-group">
					<label for="first_name">First Name:</label>
					<input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
				</div>
				<div class="form-group">
					<label for="last_name">Last Name:</label>
					<input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
				</div>
			</div>

			<div class="form-row">
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="email" id="email" name="email" placeholder="Enter your email" required>
				</div>
				<div class="form-group">
					<div class="phone-input">
						<label for="phone_number">Phone Number:</label>
						<div class="phone-input-flex">
							<select name="country-code" id="country-code">
								<option value="+1">USA (+1)</option>
								<option value="+44">UK (+44)</option>
								<option value="+254" selected>Kenya (+254)</option>
								<option value="+86">China (+86)</option>
							</select>
							<input type="tel" id="phone_number" name="phone_number" value="07" placeholder="Enter your phone number" required pattern="[0-9]{9,10}">
						</div>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="form-group">
					<label for="booking_date">Date:</label>
					<input type="date" id="booking_date" name="booking_date" min="<?php echo date('Y-m-d'); ?>" required>
				</div>
				<div class="form-group">
					<label for="booking_time">Timeslot:</label>
					<select id="booking_time" name="booking_time" required>
						<option value="" selected disabled>Select a time slot</option>
						<option value="08:00">08:00</option>
						<option value="09:00">09:00</option>
						<option value="10:00">10:00</option>
						<option value="11:00">11:00</option>
						<option value="12:00">12:00</option>
						<option value="13:00">13:00</option>
						<option value="14:00">14:00</option>
						<option value="15:00">15:00</option>
						<option value="16:00">16:00</option>
						<option value="17:00">17:00</option>
						<option value="18:00">18:00</option>
					</select>
				</div>
			</div>

			<div class="form-row">
				<div class="form-group">
					<label for="services">Select Service(s):</label>
					<select id="services" name="services" required>
						<option value="" selected disabled>Select service</option>
						<option value="makeup-400">Makeup @ 400ksh for 1hr</option>
						<option value="facials-250">Facials - Ksh. 250- 1hr</option>
						<option value="hair-300">Hair - Ksh. 300- 1hr</option>
						<option value="manicure-200">Manicure - Ksh. 200 1hr</option>
						<option value="pedicure-250">Pedicure - Ksh. 250 1hr</option>
					</select>
				</div>
				<div class="form-group">
					<label for="stylists">Select Stylist:</label>
					<select id="stylists" name="stylists" required>
						<option value="" selected disabled>Select stylist</option>
						<option value="Wendy Kimani">Wendy Kimanih</option>
						<option value="Trizah Ochieng">Trizah Ochieng</option>
						<option value="Tasha Kinyua">Tasha Kinyua</option>
						<option value="Timmo KE">Timmo KE</option>
					</select>
				</div>
			</div>
			<p> Booking fee is ksh 50 that will be discounted on paying after service<br> Please enter a valid MPESA Number below</p>
			<div class="form-group">
				<div class="phone-input">
					<label for="phone_number">Phone Number:</label>
					<div class="phone-input-flex"></div>
					<label for="phone_number">Enter your M-PESA phone number:</label>
					<input type="tel" name="phone_number" id="phone_number" required>

					<div class="form-row">
						<button type="submit" name="submit">Submit</button>
					</div>
		</form>
	</div>
	<script>
		const phoneInput = document.getElementById("phone_number");

		phoneInput.addEventListener("invalid", function() {
			if (phoneInput.validity.patternMismatch) {
				phoneInput.setCustomValidity("Input a valid phone number.");
			} else {
				phoneInput.setCustomValidity("");
			}
		});
	</script>
</body>

</html>