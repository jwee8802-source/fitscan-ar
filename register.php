<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" href="image/logo1.png" type="image/png">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Form</title>
  <style>
    *{
      margin:0;
      padding:0;
       box-sizing: border-box;
    }
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f2f2f2;
      background-image: url('image/logo3.jpeg'); 
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }

    .register-form {
      background-color: rgba(255, 255, 255, 0.7);
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 400px;
      box-sizing: border-box;
          margin-top: -50px
    }
    .form-container {
      display: flex;
      justify-content: center; 
      align-items: center; 
     
      
    }

    .back-button img {
  width: 50px;   /* adjust size ‚Äî smaller */
  height: 50px;
  cursor: pointer;
 margin-right:300px;
 margin-top:-10px;
}

    h2 {
      text-align: center;
      margin-bottom: 10px;
      color: #333;
          margin-top: -20px;
    }
  
   
    .input-field, .select-field {
      width: 100%;
      padding: 5px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    .btn {
      width: 100%;
      padding: 12px;
      background-color: #000000;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 10px;
    }

    .btn:hover {
      background-color: #000000;
    }

    .links {
      text-align: center;
      margin-top: 10px;
    }

    .links a {
      color: #000000;
      text-decoration: none;
      margin: 0 10px;
    }

    .links a:hover {
      text-decoration: underline;
    }

   
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background-color: white;
      padding: 30px;
      text-align: center;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 300px;
    }

    .modal-content h3 {
      margin: 20px 0;
      color: green;
    }

    .modal-content button {
      padding: 10px 20px;
      background-color: #000000;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .modal-content button:hover {
      background-color: #45a049;
    }

     .floating-back-btn {
    position: fixed;
    bottom: 20px;
    left: 20px;
    padding: 10px 20px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 50px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    z-index: 1000;
    font-size: 16px;
    transition: background-color 0.3s ease;
  }

  .floating-back-btn:hover {
    background-color: #2980b9;
  }
   /* üì± Mobile (up to 600px) */
  @media (max-width: 2560px) {
    body {
      flex-direction: column;
      height: auto;
      padding: 20px;
    }
   
    .register-form {
      width: 100%;
      max-width: 90%;
      max-height: 90%;
      padding: 20px;
      
    }

    .back-button {
      width: 60px;
      height: 60px;
      margin: 0 auto 10px auto;
      display: block;
      margin-right:300px;
    }

    .input-field,
    .select-field {
      font-size: 14px;
      padding: 8px;
    }

    .btn {
      font-size: 14px;
      padding: 10px;
    }

    h2 {
      font-size: 18px;
      margin-top: 0;
    }

    .floating-back-btn {
      padding: 8px 14px;
      font-size: 14px;
      bottom: 15px;
      left: 15px;
    }
  }
  @media (max-width: 2560px) {
  .register-form {
    width: 400px;
    padding: 20px;
    width:500px;
    height:100%;
  
    margin-top:50px;
  }

  .back-button img {
    width: 100%;
    height: 100%;
    margin-right:100px;
  }
  .back-button {
    width: 100%;
    height: 100%;
    margin-right:100px;
  }
}
  @media (max-width: 1440px) {
  .register-form {
    width: 400px;
    padding: 30px;
    margin-top: 5px;
  }

  .back-button img{
    width: 60px;
    height: 60px;
    margin-right: 300px;
    margin-top: -25px;
  }
    .back-button {
    width: 50px;
    height: 50px;
    margin-right: 350px;
  }
  h2 {
    font-size: 25px;
    margin-top:-50px;
  }
}
@media (max-width: 1281px) {
.input-field{
  width:100%;
}
    .back-button img {
        width: 55px;
        height: 55px;
        margin-top: -25px;
        margin-left: 20px;
    }
}
/* üñ•Ô∏è LAPTOP: 1024px and below */
@media (max-width: 1025px) {
  .register-form {
    width: 400px;
    padding: 30px;
    margin-top: 5px;
  }

  .back-button img{
    width: 60px;
    height: 60px;
    margin-right: 300px;
    margin-top: -25px;
  }
    .back-button {
    width: 50px;
    height: 50px;
    margin-right: 310px;
  }
  h2 {
    font-size: 25px;
    margin-top:-50px;
  }
  .input-field{
  width:100%;
}
}

@media (max-width: 821px) {
.input-field{
  width:100%;
}
    .back-button img {
        width: 55px;
        height: 55px;
        margin-top: -25px;
        margin-left: 20px;
    }
}

/* üì± TABLET PORTRAIT: 768px and below */
@media (max-width: 769px) {
  .register-form {
    width: 400px;
    padding: 30px;
     margin-top: 5px;
  }

  .back-button img{
    width: 50px;
    height: 50px;
     margin-top: -25px;
     margin-right: 200px;
  }
    .back-button {
    width: 50px;
    height: 50px;
    margin-right: 300px;
  }
  h2 {
    font-size: 25px;
    margin-top:-50px;
  }
.input-field{
  width:100%;
}
}

@media (max-width: 541px) {
.input-field{
  width:100%;
}
    .back-button img {
        width: 55px;
        height: 55px;
        margin-top: -25px;
        margin-left: 0px;
    }
}

@media (max-width: 431px) {
      .back-button img {
        width: 50px;
        height: 50px;
        margin-top: -20px;
        margin-left: 40px;
    }
    .register-form {
        width: 400px;
        padding: 30px;
        margin-top: 5px;
    }
.input-field{
  width:100%;
}
}

/* üì± MOBILE MEDIUM: 480px and below */
@media (max-width: 426px) {
  .register-form {
    width: 95%;
    padding: 25px;
    margin-top: 5px;
  }

  .back-button img {
    width: 45px;
    height: 45px;
   margin-top: -15px;
     margin-right: 200px;
  }
  .back-button {
    width: 50px;
    height: 50px;
    margin-right: 290px;
  }
  h2 {
    font-size: 20px;
    margin-top:-50px;
  }

  .btn {
    font-size: 14px;
  }
}

@media (max-width: 415px) {
.input-field{
  width:100%;
}
}
@media (max-width: 413px) {
    .back-button img {
        width: 50px;
        height: 50px;
        margin-top: -20px;
        margin-left: 20px;
    }
}
@media (max-width: 391px) {
    .back-button img {
        width: 45px;
        height: 45px;
        margin-top: -15px;
        margin-left: 30px;
    }
}

/* üì± MOBILE SMALL: 375px and below */
@media (max-width: 376px) {
  .register-form {
    width: 380px;
    padding: 20px;
     margin-top: 5px;
  }

  .back-button img{
    width: 50px;
    height: 50px;
    margin-top: -10px;
     margin-right: 200px;
  }
   .back-button {
    width: 50px;
    height: 50px;
    margin-right: 270px;
  }

  h2 {
    font-size: 20px;
    margin-top:-40px;
  }
  .input-field{
    width:100%;
  }
  
}

@media (max-width: 361px) {
.input-field{
  width:100%;
}
    .back-button img {
        width: 50px;
        height: 50px;
        margin-top: -15px;
        margin-left: 30px;
    }
}

@media (max-width: 344px) {
.input-field{
  width:100%;
}
    .back-button img {
        width: 50px;
        height: 50px;
        margin-top: -15px;
        margin-left: 35px;
    }
}

/* üì± VERY SMALL PHONES: 321px and below */
@media (max-width: 321px) {
  .register-form {
    width: 100%;
    padding: 25px;
    margin-top: 5px;
  }
  .back-button  img{
    width: 50px;
    height: 50px;
    margin-right: 240px;
    margin-top: -20px;
  }
  .back-button {
    width: 50px;
    height: 50px;
    margin-right: 200px;
  }

  h2 {
    font-size: 17px;
    margin-top:-50px;
  }

  .btn {
    font-size: 12px;
    padding: 10px;
  }

  .input-field, .select-field {
    font-size: 14px;
  }

  .floating-back-btn {
    font-size: 13px;
    padding: 8px 15px;
  }
}
  </style>
</head>
<body>

<div class="register-form">
   <div class="form-box">
      <div class="form-container">
  <a href="login.php" class="back-button">
    <img src="image/bbutton.png" alt="Back" />
  </a>
</div>
  <h2>Register</h2>
  <form action="register_function.php" method="POST">
    <!-- Email -->
    <input type="email" class="input-field" name="email" placeholder="Email" required>

    <!-- Full Name -->
    <input type="text" class="input-field" name="username" placeholder="Full Name" required>

    <!-- Password -->
    <input type="password" class="input-field" name="password" placeholder="Password" required id="password">

    <!-- Confirm Password -->
    <input type="password" class="input-field" name="confirm_password" placeholder="Confirm Password" required id="confirm-password">

    <!-- Show Password Checkbox -->
    <div style="margin: 10px 0;">
      <label>
        <input type="checkbox" id="show-password"> Show Password
      </label>
    </div>

    <!-- Phone Number -->
    <input type="tel" class="input-field" name="phone" placeholder="Phone Number" required pattern="[0-9]{10,15}" title="Enter a valid phone number (10-15 digits)">

    <!-- Gender -->
    <select class="select-field" name="gender" required>
      <option value="" disabled selected>Gender</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
      <option value="Other">Other</option>
    </select>

    <!-- Address Section -->
    <h3>Address</h3>

    <!-- Province -->
    <select class="select-field" name="province" id="province" required>
      <option value="" disabled selected>Province</option>
      <option value="Pampanga">Pampanga</option>
    </select>

    <!-- Municipality -->
    <select class="select-field" name="municipality" id="municipality" style="display:none;" required>
      <option value="" disabled selected>Municipality</option>
    </select>

    <!-- Barangay -->
    <select class="select-field" name="barangay" id="barangay" style="display:none;" required>
      <option value="" disabled selected>Barangay</option>
    </select>

    <!-- Street -->
<input type="text" class="input-field" name="street" id="street" placeholder="Street Name, House No." style="display:none;" required>

    <!-- Submit Button -->
    <button type="submit" class="btn">Register</button>
  </form>

  <div class="links">
    <a href="login.php">Already have an account? Login</a>
  </div>
</div>

<!-- JavaScript Section -->
<script>
  const provinceSelect = document.getElementById('province');
  const municipalitySelect = document.getElementById('municipality');
  const barangaySelect = document.getElementById('barangay');
  const streetSelect = document.getElementById('street');

  function updateMunicipalities(province) {
    let municipalities = [];

    if (province === 'Pampanga') {
      municipalities = ['Porac', 'Angeles', 'Florida','Bacolor','Lubao','Sta Rita','Guagua','San Fernando'];


         }

    municipalitySelect.innerHTML = '<option value="" disabled selected>Municipality</option>';
    municipalities.forEach(municipality => {
      let option = document.createElement('option');
      option.value = municipality;
      option.textContent = municipality;
      municipalitySelect.appendChild(option);
    });
    municipalitySelect.style.display = 'block';
  }

  function updateBarangays(municipality) {
    let barangays = [];

    if (municipality === 'Angeles') {
    barangays = ['Agapito del Rosario','Amsic','Anunas','Balibago','Capaya','Claro M. Recto','Cuayan','Cutcut','Cutud','Lourdes Northwest','Lourdes Sur','Lourdes Sur East','Malabanas','Margot','Mining','Ninoy Aquino','Pampang','Pandan','Pulung Cacutud','Pulung Maragul','Pulungbulu','Salapungan','San Jose','San Nicolas','Santa Teresita','Santa Trinidad','Santo Cristo','Santo Domingo','Santo Rosario','Sapalibutad','Sapangbato','Tabun','Virgen Delos Remedios'];

    } else if (municipality === 'Porac') {
  barangays = ['Babo Pangulo','Babo Sacan','Balubad','Calzadang Bayu','Camias','Cangatba','Diaz','Dolores','Inararo','Jalung','Mancatian','Manibaug Libutad','Manibaug Paralaya','Manibaug Pasig','Manuali','Mitla Proper','Palat','Pias','Pio','Planas','Poblacion','Pulung Santol','Salu','San Jose Mitla','Santa Cruz','Sapang Uwak','Sepung Bulaun','Sinura','Villa Maria'];

    } else if (municipality === 'Florida') {
     barangays = ['Anon','Apalit','Basa Air Base','Benedicto','Bodega','Cabangcalan','Calantas','Carmencita','Consuelo','Dampe','Del Carmen','Fortuna','Gutad','Mabical','Maligaya','Mawacat','Nabuclod','Pabanlag','Paguiruan','Palmayo','Pandaguirig','Poblacion','San Antonio','San Isidro','San Jose','San Nicolas','San Pedro','San Ramon','San Roque','Santa Monica','Solib','Santo Rosario','Valdez'];

    } else if (municipality === 'Bacolor') {
  barangays = ['Balas','Cabalantian','Cabambangan (Poblacion)','Cabetican','Calibutbut','Concepcion','Dolores','Duat','Macabacle','Magliman','Maliwalu','Mesalipit','Parulog','Potrero','San Antonio','San Isidro','San Vicente','Santa Barbara','Santa Ines','Talba','Tinajero'];

} else if (municipality === 'Lubao') {
  barangays = ['San isidro', 'Santiago', 'Santo Nino (Prado Saba)', 'San Roque Arbol', 'Baruya (San Rafael)', 'Lourdes (Lauc Pau)', 'Prado Siongco', 'San Jose Gumi', 'Balantacan', 'Santa Teresa†2nd', 'Bancal Sinubli', 'Bancal Pugad', 'Calangain', 'San Pedro Palcarangan', 'San Pedro Saug', 'San Pablo 1st', 'San Pablo 2nd', 'De La Paz', 'Santa cruz', 'Remedios', 'Santa Maria', 'Del Carmen', 'San Agustin', 'Santa Rita', 'Santa Teresa 1st', 'Santo Tomas (Poblacion)', 'San Roque Dau', 'Santo Cristo', 'San Matias', 'Don Ignacio Dimson', 'Santa Monica', 'Santo Domingo', 'San Miguel', 'Concepcion', 'San Francisco', 'San Vicente', 'San Antonio', 'San Jose Apunan', 'San Nicolas†1st (Pob.)', 'San Nicolas†2nd', 'San Juan (Pob.)', 'Santa Barbara', 'Santa Catalina', 'Santa Lucia (Pob.)'];

} else if (municipality === 'Sta Rita') {
  barangays = ['San Basilio', 'Dila-dila', 'Becuran', 'San lsidro', 'San Jose (Poblacion)', 'San matias', 'San Vicente', 'Santa monica', 'San agustin'];

} else if (municipality === 'San Fernando') {
  barangays = ['Alasas', 'Baliti', 'Bulaon', 'Calulut', 'Dela Paz Norte', 'Dela Paz Sur', 'Del Carmen', 'Del Pilar', 'Del Rosario', 'Dolores', 'Juliana', 'Lara', 'Lourdes', 'Maimpis', 'Magliman', 'Malino', 'Malpitic', 'Pandaras', 'Panipuan', 'Pulung Bulo', 'Santo Rosario (Poblacion)', 'Quebiawan', 'Saguin', 'San Agustin', 'San Felipe', 'San Isidro', 'San Jose', 'San Juan', 'San Nicolas', 'San Pedro Cutud', 'Santa Lucia', 'Santa Teresita', 'Santo NiÒo', 'Sindalan', 'Telabastagan'];

} else if (municipality === 'Guagua') {
  barangays = ['Ascomo Guagua', 'Bancal Guagua', 'Jose Abad Santos (Siran) Guagua', 'Lambac Guagua', 'Magsaysay Guagua', 'Maquiapo Guagua', 'Natividad Guagua', 'Plaza Burgos Guagua', 'Pulungmasle Guagua', 'Rizal Guagua', 'San Agustin Guagua', 'San Antonio Guagua', 'San Isidro Guagua', 'San Jose Guagua', 'San Juan Bautista Guagua', 'San Juan Nepomuceno Guagua', 'San Matias Guagua', 'San Miguel (Betis) Guagua', 'San Nicolas 1st Guagua', 'San Nicolas 2nd Guagua', 'San Pablo Guagua', 'San Pedro Guagua', 'San Rafael Guagua', 'San Roque Guagua', 'San Vicente (Ebus) Guagua', 'Santa Filomena Guagua', 'Santa Ines Guagua', 'Santa Ursula Guagua', 'Santo Cristo Guagua', 'Santo NiÒo Guagua'];
        
}

    barangaySelect.innerHTML = '<option value="" disabled selected>Barangay</option>';
    barangays.forEach(barangay => {
      let option = document.createElement('option');
      option.value = barangay;
      option.textContent = barangay;
      barangaySelect.appendChild(option);
    });
    barangaySelect.style.display = 'block';
  }

  function updateStreets(barangay) {
    let streets = [];

    




    streetSelect.innerHTML = '<option value="" disabled selected>Street</option>';
    streets.forEach(street => {
      let option = document.createElement('option');
      option.value = street;
      option.textContent = street;
      streetSelect.appendChild(option);
    });
    streetSelect.style.display = 'block';
  }

  provinceSelect.addEventListener('change', function () {
    municipalitySelect.style.display = 'none';
    barangaySelect.style.display = 'none';
    streetSelect.style.display = 'none';
    if (this.value) {
      updateMunicipalities(this.value);
    }
  });

  municipalitySelect.addEventListener('change', function () {
    barangaySelect.style.display = 'none';
    streetSelect.style.display = 'none';
    if (this.value) {
      updateBarangays(this.value);
    }
  });

  barangaySelect.addEventListener('change', function () {
    streetSelect.style.display = 'none';
    if (this.value) {
      updateStreets(this.value);
    }
  });

  // Form Validation: Password Match
  const form = document.querySelector('form');
  form.addEventListener('submit', function (event) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    if (password !== confirmPassword) {
      event.preventDefault();
      alert("Passwords do not match.");
      return;
    }

    // Optional: Simulate a delay before submitting
    event.preventDefault();
    setTimeout(function () {
      form.submit();
    }, 3000);
  });

  // Show Password Toggle
  const showPasswordCheckbox = document.getElementById('show-password');
  const passwordInput = document.getElementById('password');
  const confirmPasswordInput = document.getElementById('confirm-password');

  showPasswordCheckbox.addEventListener('change', function () {
    const type = this.checked ? 'text' : 'password';
    passwordInput.type = type;
    confirmPasswordInput.type = type;
  });


</script>


</body>
</html>
