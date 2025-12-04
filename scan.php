<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fit Scan - Shoe Sizing</title>
  <style>
    * { box-sizing: border-box; }
    html, body { height: 100%; margin: 0; padding: 0; font-family: 'Arial', sans-serif; background-color: #f8f9fa; text-align: center; }
    .header { display: flex; justify-content: space-between; align-items: center; padding: 15px 30px; background-color: #000; color: white; height: 80px; position: fixed; top: 0; width: 100%; z-index: 1000; }
.logo img,
.second-logo img {
  height: 50px;
  width: 50px;
  object-fit: cover;
  border-radius: 50%;
  border: 3px solid #ffffff; 
  box-shadow: none;        }
    .container { width: 100%; min-height: 100vh; padding: 20px; background: #fff; display: flex; flex-direction: column; align-items: center; margin-top: 100px; }
    h2 { font-size: 26px; font-weight: bold; margin-bottom: 10px; }
    .button { padding: 10px 15px; margin: 10px; border: none; cursor: pointer; border-radius: 8px; font-size: 16px; background: #000; color: white; }
    .chat-box { margin-top: 20px; text-align: left; max-height: 300px; overflow-y: auto; width: 100%; }
    .chat-bubble { padding: 10px; border-radius: 10px; max-width: 80%; margin: 5px auto; }
    .ai-bubble { background-color: #e9ecef; color: black; text-align: left; }
    .hidden { display: none; }
    video, canvas { width: 100%; max-width: 300px; border-radius: 12px; margin-top: 10px; border: 4px dashed #000; }
    #foot-width-result { margin-top: 15px; font-size: 18px; font-weight: bold; }
    #feet-guide { width: 250px; border-radius: 10px; margin-bottom: 15px; border: 3px solid #000; }

    /* BLACK MODERN LOADING OVERLAY */
    .loading-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.88); display: none; justify-content: center; align-items: center; flex-direction: column; z-index: 9999; }
    .loader-logo-container { position: relative; width: 130px; height: 130px; display: flex; justify-content: center; align-items: center; }
    .loader-logo-container img.loader-logo { width: 85px; height: 85px; object-fit: contain; z-index: 2; }
    .rotate-ring { position: absolute; width: 130px; height: 130px; border-radius: 50%; border: 5px solid transparent; background: conic-gradient(from 0deg, rgba(255,255,255,0.1), white, rgba(255,255,255,0.1)); animation: spin 0.9s linear infinite; mask: radial-gradient(circle, transparent 60%, black 61%); }
    @keyframes spin { to { transform: rotate(360deg); } }
    .loading-text { margin-top: 25px; color: white; font-size: 22px; font-weight: 500; letter-spacing: 2px; text-shadow: 0 0 10px rgba(255,255,255,0.6); }
    .loading-text span { display: inline-block; animation: jump 1s ease-in-out infinite; }
    @keyframes jump { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

    /* User options & home button */
    .user-options { display: flex; align-items: center; gap: 20px; }
    .home-button { display: inline-flex; align-items: center; justify-content: center; padding: 10px; border-radius: 20px; text-decoration: none; transition: background-color 0.3s ease; }
    .home-button:hover { background-color: #eeeeee; }
    .home-button img { width: 24px; height: 24px; display: block; } 
  </style>
</head>
<body>

<header class="header">
  <div class="logo-container">
    <div class="logo"><a href="home.php"><img src="image/logo1.png" alt="Shoe Store Logo"></a></div>
      </div>
  <div class="user-options">
    <a href="home.php" class="home-button" title="Home"><img src="image/home.png" alt="Home Icon"></a>
  </div>
</header>

<div class="container">
  <h2>Fit Scan - Shoe Sizing</h2>
  <p>Take a photo of your foot to check if it fits a standard shoe size.</p>
  <div id="instruction-text">📷 Instruction: Position your feet before capturing</div>
  <img id="feet-guide" src="image/feet.jpg" alt="Feet Position Guide">
  <button id="scan-btn" class="button">Scan My Foot</button>

  <video id="camera-preview" autoplay class="hidden"></video>
  <button id="capture-btn" class="button hidden">Capture</button>
  <canvas id="camera-canvas" class="hidden"></canvas>

  <div id="chat-box" class="chat-box"></div>
  <div id="foot-width-result"></div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingScreen">
  <div class="loader-logo-container">
    <img src="image/logo1.png" alt="Logo" class="loader-logo">
    <div class="rotate-ring"></div>
  </div>
  <div class="loading-text" id="loadingText">Processing...</div>
</div>

<script>
  const scanBtn = document.getElementById("scan-btn");
  const cameraPreview = document.getElementById("camera-preview");
  const cameraCanvas = document.getElementById("camera-canvas");
  const captureBtn = document.getElementById("capture-btn");
  const chatBox = document.getElementById("chat-box");
  const footWidthResult = document.getElementById("foot-width-result");
  const loadingScreen = document.getElementById("loadingScreen");

  // Animate loading text
  document.addEventListener("DOMContentLoaded", () => {
    const textElement = document.getElementById("loadingText");
    const text = textElement.textContent;
    textElement.textContent = "";
    text.split("").forEach((letter, index) => {
      const span = document.createElement("span");
      span.textContent = letter;
      span.style.animationDelay = `${index * 0.15}s`;
      textElement.appendChild(span);
    });
  });

  scanBtn.addEventListener("click", async () => {
    resetScan();
    try {
      const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });
      cameraPreview.srcObject = stream;
      cameraPreview.classList.remove("hidden");
      captureBtn.classList.remove("hidden");
    } catch (error) {
      alert("Camera error: " + error.message);
    }
  });

  captureBtn.addEventListener("click", async () => {
    const context = cameraCanvas.getContext("2d");
    cameraCanvas.width = cameraPreview.videoWidth;
    cameraCanvas.height = cameraPreview.videoHeight;
    context.drawImage(cameraPreview, 0, 0, cameraCanvas.width, cameraCanvas.height);

    // Stop camera
    cameraPreview.srcObject.getTracks().forEach(track => track.stop());
    cameraPreview.classList.add("hidden");
    captureBtn.classList.add("hidden");

    const base64Image = cameraCanvas.toDataURL("image/jpeg").split(',')[1];

    loadingScreen.style.display = "flex";

    const detectionResult = await detectFootOrShoe(base64Image);

    if (detectionResult === "none") {
      addMessage("⚠️ No foot detected in the image. Please try again.", "ai");
      loadingScreen.style.display = "none";
      return;
    }

    if (detectionResult === "foot" || detectionResult === "shoe") {
      await processImage(base64Image);
    }

    loadingScreen.style.display = "none";
  });

  async function detectFootOrShoe(base64Image) {
    try {
     const response = await fetch("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyAm1ySnJnZbMkKPSvv6MFSyXKMRdapjJag", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          contents: [{ parts: [{ text: "Does this image contain a human foot, a shoe, or neither? Reply only with one word: foot, shoe, or none." }, { inlineData: { mimeType: "image/jpeg", data: base64Image } }] }]
        })
      });
      const data = await response.json();
      const reply = data.candidates?.[0]?.content?.parts?.[0]?.text.trim().toLowerCase() || "none";
      if (reply.includes("foot")) return "foot";
      if (reply.includes("shoe")) return "shoe";
      return "none";
    } catch (error) {
      console.error("Foot/shoe detection failed:", error);
      return "none";
    }
  }

  async function processImage(base64Image) {
    footWidthResult.textContent = "";
    const prompt = `
Analyze the following image and determine if it contains a human foot:

1. If the image contains **exactly one foot**, and the foot is fully visible without obstruction (no hands, objects, or other body parts covering it), provide the following:
   - Approximate foot length in centimeters (cm)
   - Estimated US shoe size (specify Male or Female), EU size, and CM size
   - Whether the foot is bulky/wide, slim/narrow, or regular width
   - Shoe fit recommendations (e.g., wide fit shoes, arch support, etc.)

Definitions:
- Slim: Narrow foot width with less volume around the ball.
- Regular: Average foot width suitable for standard shoes.
- Bulky: Wide foot with extra volume, requiring wide-fit shoes.

2. If the image contains **multiple feet**, **no feet**, or the foot is **partially obstructed by hands or objects**, respond **only with** the text:  
“⚠️ Foot not recognized. Please scan one fully visible foot at a time.”

Provide the result in this structured format **only for single, unobstructed foot images**:

<b>Fit Scan Result</b>  
Foot Length: [e.g., 24.5 cm]  
Estimated Size: [US Men's 8 / US Women's 9 / EU 41 / 25.5 cm]  
Foot Width Type: [Slim / Regular / Bulky]  
Fit Recommendation: [e.g., Wide fit recommended for comfort]

Notes:  
[Optional comments about arch type, toe shape, or scan image clarity]

Do not include greetings or any extra text outside the result.

`;
    try {
     const response = await fetch("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyAm1ySnJnZbMkKPSvv6MFSyXKMRdapjJag", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          contents: [{ parts: [{ text: prompt }, { inlineData: { mimeType: "image/jpeg", data: base64Image } }] }]
        })
      });
      const data = await response.json();
      const aiReply = data.candidates?.[0]?.content?.parts?.[0]?.text || "⚠️ No response from AI.";
      addMessage(aiReply, "ai");

      const widthMatch = aiReply.match(/Foot Width Type:\s*(Slim|Regular|Bulky)/i);
      if (widthMatch) {
        const width = widthMatch[1];
        footWidthResult.textContent = `👣 Foot Width Detected: ${width}`;
        footWidthResult.style.color = width === "Bulky" ? "red" : width === "Slim" ? "blue" : "green";
      }const overlayMatch = aiReply.match(/Foot Length:\s*(.+?)\s+Estimated Size:\s*(.+?)\s+Foot Width Type:/i);
      if (overlayMatch) {
        const lengthText = overlayMatch[1].trim();
        const sizeText = overlayMatch[2].trim();

        const ctx = cameraCanvas.getContext("2d");

        // Draw the foot outline first (before text)
        outlineFoot();

        // Draw the semi-transparent black background rectangle for text
        ctx.font = "20px Arial";
        ctx.fillStyle = "rgb(255, 255, 255)";
        ctx.fillRect(10, 10, cameraCanvas.width - 20, 70);

        // Draw the text on top of the background
        ctx.fillStyle = "black";
        ctx.fillText(`Foot Length: ${lengthText}`, 20, 40);
        ctx.fillText(`Size: ${sizeText}`, 20, 65);

        // Draw red underline below size text
        const textMetrics = ctx.measureText(`Size: ${sizeText}`);
        ctx.beginPath();
        ctx.moveTo(20, 70);
        ctx.lineTo(20 + textMetrics.width, 70);
        ctx.strokeStyle = "red";
        ctx.lineWidth = 1.5;
        ctx.stroke();

        cameraCanvas.classList.remove("hidden");
      }

    } catch (error) {
      addMessage("⚠️ Error: " + error.message, "ai");
    }
  }

  function outlineFoot() {
    const ctx = cameraCanvas.getContext("2d");
    const width = cameraCanvas.width;
    const height = cameraCanvas.height;
    const imageData = ctx.getImageData(0,0,width,height);
    const data = imageData.data;
    const edgeData = ctx.createImageData(width,height);
    const edgePixels = edgeData.data;

    for(let y=1;y<height-1;y++){
      for(let x=1;x<width-1;x++){
        const idx = (y*width+x)*4;
        const gray = (data[idx]+data[idx+1]+data[idx+2])/3;
        const grayLeft=(data[idx-4]+data[idx-3]+data[idx-2])/3;
        const grayRight=(data[idx+4]+data[idx+5]+data[idx+6])/3;
        const grayUp=(data[idx-width*4]+data[idx-width*4+1]+data[idx-width*4+2])/3;
        const grayDown=(data[idx+width*4]+data[idx+width*4+1]+data[idx+width*4+2])/3;
        const edgeStrength=Math.abs(grayRight-grayLeft)+Math.abs(grayDown-grayUp);
        if(edgeStrength>30){ edgePixels[idx]=255; edgePixels[idx+1]=0; edgePixels[idx+2]=0; edgePixels[idx+3]=255; }
        else edgePixels[idx+3]=0;
      }
    }
    ctx.putImageData(edgeData,0,0);
    cameraCanvas.classList.remove("hidden");
  }

  function addMessage(text,type){
    const bubble=document.createElement("div");
    bubble.classList.add("chat-bubble",type==="user"?"user-bubble":"ai-bubble");
    bubble.innerHTML=text;
    chatBox.appendChild(bubble);
    chatBox.scrollTop=chatBox.scrollHeight;
  }

  function resetScan(){
    chatBox.innerHTML="";
    footWidthResult.textContent="";
    const ctx=cameraCanvas.getContext("2d");
    ctx.clearRect(0,0,cameraCanvas.width,cameraCanvas.height);
    cameraCanvas.classList.add("hidden");
    if(cameraPreview.srcObject){cameraPreview.srcObject.getTracks().forEach(track=>track.stop());}
    cameraPreview.classList.add("hidden");
    captureBtn.classList.add("hidden");
  }
</script>
</body>
</html>
