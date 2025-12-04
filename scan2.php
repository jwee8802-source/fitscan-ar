<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fit Scan - Shoe Sizing</title>
  <style>
    * {
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      font-family: 'Arial', sans-serif;
      background-color: #f8f9fa;
      text-align: center;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      background-color: #000000;
      color: white;
      height: 80px;
      width: 100%;
      position: fixed;
      top: 0;
      z-index: 1000;
    }

    .logo img {
      height: 50px;
      margin-left: 15px;
      border: 2px solid white;
      border-radius: 50%;
      padding: 5px;
      background-color: rgba(255, 255, 255, 0.05);
    }

    .container {
      width: 100%;
      min-height: 100vh;
      padding: 20px;
      background: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 100px;
    }

    #instruction-text {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    #feet-guide {
      width: 250px;
      border-radius: 10px;
      margin-bottom: 15px;
      border: 3px solid #000;
    }

    video, canvas {
      width: 100%;
      max-width: 300px;
      border-radius: 12px;
      margin-top: 10px;
      border: 4px dashed #000;
    }

    .button {
      padding: 10px 15px;
      margin: 10px;
      border: none;
      cursor: pointer;
      border-radius: 8px;
      font-size: 16px;
      background: #000;
      color: white;
    }

    .hidden {
      display: none;
    }

    .chat-box {
      margin-top: 20px;
      text-align: left;
      max-height: 300px;
      overflow-y: auto;
      width: 100%;
    }/* BLACK MODERN LOADING OVERLAY */
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.88);
  display: none;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  z-index: 9999;
}

/* Container for logo and rotating ring */
.loader-logo-container {
  position: relative;
  width: 120px;
  height: 120px;
}

/* Logo sa gitna */
.loader-logo-container img {
  width: 85px;
  height: 85px;
  object-fit: contain;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  filter: drop-shadow(0 0 3px white);
}

/* Rotating circle */
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.88);
  display: none;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  z-index: 9999;
}

.loader-logo-container {
  position: relative;
  width: 130px;   /* Adjust size as needed */
  height: 130px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.loader-logo-container img.loader-logo {
  width: 85px;
  height: 85px;
  object-fit: contain;
  z-index: 2; /* Always above the ring */
}

.rotate-ring {
  position: absolute;
  width: 130px;
  height: 130px;
  border-radius: 50%;
  border: 5px solid transparent;
  background: conic-gradient(
      from 0deg,
      rgba(255,255,255,0.1),
      white,
      rgba(255,255,255,0.1)
  );
  animation: spin 0.9s linear infinite;
  mask: radial-gradient(circle, transparent 60%, black 61%);
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Add this to your existing CSS */
.loading-text {
  margin-top: 25px;
  color: white;
  font-size: 22px;
  font-weight: 500;
  letter-spacing: 2px;
  text-shadow: 0 0 10px rgba(255,255,255,0.6);
}.loading-text span {
  display: inline-block;
  animation: jump 1s ease-in-out infinite; /* mas mabagal ang jump, dati 0.6s */
}

@keyframes jump {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px); /* taas ng talon */
  }
}

  </style>
</head>
<body>

<header class="header">
  <div class="logo">
    <a href="home.php">
      <img src="image/logo1.png" alt="Shoe Store Logo">
    </a>
  </div>
  <a href="home.php" class="home-button">
    <img src="image/home.png" alt="Home Icon" style="width:40px;height:40px;">
  </a>
</header>

<div class="container">
  <h2>Fit Scan - Shoe Sizing</h2>
  <p>Take a photo of your foot to check if it fits a standard shoe size.</p>

 <div id="instruction-text">📌 Instruction: Position your feet before capturing</div>
  <img id="feet-guide" src="image/feet.jpg" alt="Feet Position Guide">

  <button id="scan-btn" class="button">Scan My Foot</button>

  <video id="camera-preview" autoplay class="hidden"></video>
  <button id="capture-btn" class="button hidden">Capture</button>
  <canvas id="camera-canvas" class="hidden"></canvas>

  <div id="chat-box" class="chat-box"></div>
  <div id="foot-width-result"></div>
<div id="outline-container" style="margin-top:20px;"></div>
</div>

<script>
const scanBtn = document.getElementById("scan-btn");
const cameraPreview = document.getElementById("camera-preview");
const cameraCanvas = document.getElementById("camera-canvas");
const captureBtn = document.getElementById("capture-btn");
const chatBox = document.getElementById("chat-box");
const footWidthResult = document.getElementById("foot-width-result");

// Scan button
scanBtn.addEventListener("click", async () => {
  clearPreviousResults();
  try {
    const stream = await navigator.mediaDevices.getUserMedia({
      video: { facingMode: "environment" }
    });
    cameraPreview.srcObject = stream;
    cameraPreview.classList.remove("hidden");
    captureBtn.classList.remove("hidden");
  } catch (error) {
    alert("Camera error: " + error.message);
  }
});
// =====================
// ?? CAPTURE BUTTON
// =====================
captureBtn.addEventListener("click", async () => {
  const loading = document.getElementById("loadingScreen");
  loading.style.display = "flex";

  const context = cameraCanvas.getContext("2d");
  cameraCanvas.width = cameraPreview.videoWidth;
  cameraCanvas.height = cameraPreview.videoHeight;

  // Draw from camera
  context.drawImage(cameraPreview, 0, 0, cameraCanvas.width, cameraCanvas.height);

  // Stop camera
  cameraPreview.srcObject.getTracks().forEach(track => track.stop());
  cameraPreview.classList.add("hidden");
  captureBtn.classList.add("hidden");

  // Convert to Base64
  const base64Image = cameraCanvas.toDataURL("image/jpeg").split(',')[1];

  const detectionResult = await detectFootOrShoe(base64Image);
  if (detectionResult === "none") {
    addMessage("?? No foot detected. Please try again.", "ai");
    loading.style.display = "none";
    return;
  }

  // Process only if foot detected
  await processImage(base64Image);

  loading.style.display = "none";
});

// =====================
// CLEAR PREVIOUS RESULTS
// =====================
function clearPreviousResults() {
  chatBox.innerHTML = "";
  footWidthResult.textContent = "";
  const ctx = cameraCanvas.getContext("2d");
  ctx.clearRect(0, 0, cameraCanvas.width, cameraCanvas.height);
  cameraCanvas.classList.add("hidden");
}

// =====================
// ?? RED OUTLINE GENERATOR
// =====================
function generateRedOutlineImage(base64Image) {
  return new Promise((resolve) => {
    const img = new Image();
    img.src = "data:image/jpeg;base64," + base64Image;

    img.onload = () => {
      const c = document.createElement("canvas");
      const ctx = c.getContext("2d");
      c.width = img.width;
      c.height = img.height;

      ctx.drawImage(img, 0, 0);

      const imageData = ctx.getImageData(0, 0, c.width, c.height);
      const data = imageData.data;

      // Simple edge detection
      for (let i = 0; i < data.length; i += 4) {
        const brightness = (data[i] + data[i + 1] + data[i + 2]) / 3;

        if (brightness > 128) {
          data[i + 3] = 0; // transparent light areas
        } else {
          data[i] = 255;   // RED outline
          data[i + 1] = 0;
          data[i + 2] = 0;
          data[i + 3] = 255;
        }
      }

      ctx.putImageData(imageData, 0, 0);
      resolve(c.toDataURL("image/png"));
    };
  });
}

// =====================
// FOOT / SHOE DETECTION
// =====================
async function detectFootOrShoe(base64Image) {
  try {
    const response = await fetch(
      "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyAm1ySnJnZbMkKPSvv6MFSyXKMRdapjJag",
      {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
          contents: [
            {
              parts: [
                { text: "Does this image contain a human foot, a shoe, or neither? Reply only with foot, shoe, or none." },
                { inlineData: { mimeType: "image/jpeg", data: base64Image } }
              ]
            }
          ]
        })
      }
    );

    const data = await response.json();
    const reply = data.candidates?.[0]?.content?.parts?.[0]?.text?.trim().toLowerCase() || "none";

    if (reply.includes("foot")) return "foot";
    if (reply.includes("shoe")) return "shoe";
    return "none";

  } catch (error) {
    console.error("Detection failed:", error);
    return "none";
  }
}

// =====================
// MAIN FOOT ANALYSIS
// =====================
async function processImage(base64Image) {
  const prompt = `
Analyze the following image of a human foot and determine:
1. The approximate foot length in centimeters (cm).
2. Estimated US shoe size (Male/Female), EU size, and CM size.
3. Foot width type (Slim, Regular, Bulky).
4. Shoe fit recommendations.

Format:
<b>Fit Scan Result</b><br>
Foot Length: [cm]<br>
Estimated Size: [sizes]<br>
Foot Width Type: [Slim / Regular / Bulky]
`;

  try {
    const response = await fetch(
      "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyAm1ySnJnZbMkKPSvv6MFSyXKMRdapjJag",
      {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          contents: [
            {
              parts: [
                { text: prompt },
                { inlineData: { mimeType: "image/jpeg", data: base64Image } }
              ]
            }
          ]
        })
      }
    );

    const data = await response.json();
    const aiReply =
      data.candidates?.[0]?.content?.parts?.[0]?.text ||
      "?? No response from AI.";

    addMessage(aiReply, "ai");

    // Extract width type
    const widthMatch = aiReply.match(/Foot Width Type:\s*(Slim|Regular|Bulky)/i);
    if (widthMatch) {
      const width = widthMatch[1];
      footWidthResult.textContent = `?? Foot Width Detected: ${width}`;
      footWidthResult.style.color =
        width === "Bulky" ? "red" :
        width === "Slim" ? "blue" :
        "green";
    }

    // ?? Show Outline Image
    generateRedOutlineImage(base64Image).then(outlineImg => {
      const outlineContainer = document.getElementById("outline-container");
      outlineContainer.innerHTML = `
        <h3 style="margin-top:10px;">Red Outline Preview</h3>
        <img src="${outlineImg}" style="width:260px;border:3px dashed red;border-radius:12px;">
      `;
    });

  } catch (error) {
    addMessage("?? Error: " + error.message, "ai");
  }
}

// =====================
// CHAT BUBBLE SYSTEM
// =====================
function addMessage(text, type) {
  const bubble = document.createElement("div");
  bubble.classList.add("chat-bubble", type === "user" ? "user-bubble" : "ai-bubble");
  bubble.innerHTML = text;
  chatBox.appendChild(bubble);
  chatBox.scrollTop = chatBox.scrollHeight;
}
</script>


<!-- BLACK MODERN LOADING OVERLAY -->
<div class="loading-overlay" id="loadingScreen">
    <div class="loader-logo-container">
        <img src="image/logo1.png" alt="Logo">
        <div class="rotate-ring"></div>
    </div>
    <div class="loading-text" id="loadingText">Processing...</div>
</div>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const loadingText = document.getElementById('loadingText');
    if (!loadingText) return; // safety check
    const text = loadingText.textContent;
    loadingText.textContent = '';

    text.split('').forEach((char, i) => {
        const span = document.createElement('span');
        span.textContent = char;
        span.style.animationDelay = `${i * 0.15}s`; // isa-isa tumalon
        loadingText.appendChild(span);
    });
});
</script>


</body>
</html>
