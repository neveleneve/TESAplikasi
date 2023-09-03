// public/js/sketch.js
let slots = [];
let slotWidth;
let slotHeight;

function setup() {
  let canvas = createCanvas(400, 400);
  canvas.parent("parkingCanvas");
  loadSlotParkirData();
}

function draw() {
  background(220);
  textSize(18);
  textAlign(CENTER, CENTER);

  let xMargin = 50;
  let yMargin = 50;
  let spacing = 20;
  let cols = 5;

  for (let i = 0; i < slots.length; i++) {
    let row = floor(i / cols);
    let col = i % cols;
    let x = xMargin + col * (slotWidth + spacing);
    let y = yMargin + row * (slotHeight + spacing);

    if (slots[i].is_booked) {
      fill("red");
    } else {
      fill(slots[i].selected ? "blue" : "green");
    }

    rect(x, y, slotWidth, slotHeight);
    fill(255);
    text(slots[i].name, x + slotWidth / 2, y + slotHeight / 2);
  }
}

function mouseClicked() {
  let xMargin = 50;
  let yMargin = 50;
  let spacing = 20;
  let cols = 5;

  for (let i = 0; i < slots.length; i++) {
    let row = floor(i / cols);
    let col = i % cols;
    let x = xMargin + col * (slotWidth + spacing);
    let y = yMargin + row * (slotHeight + spacing);

    if (
      mouseX >= x &&
      mouseX <= x + slotWidth &&
      mouseY >= y &&
      mouseY <= y + slotHeight &&
      !slots[i].is_booked
    ) {
      slots[i].selected = !slots[i].selected;
    }
  }
}

function windowResized() {
  // Resize the canvas when the window is resized
  resizeCanvas(windowWidth * 0.8, windowHeight * 0.8);
  adjustSlotSize();
}

function loadSlotParkirData() {
  fetch("/api/slot_parkir")
    .then((response) => response.json())
    .then((data) => {
      slots = data.map((slot) => {
        return {
          ...slot,
          selected: false,
        };
      });
      adjustSlotSize();
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
    });
}

function adjustSlotSize() {
  // Adjust slot size based on the modal's width
  let canvasContainer = select("#canvasContainer");
  let canvasWidth = canvasContainer.width();
  let canvasHeight = canvasWidth * 0.75; // Set the height as needed (e.g., 75% of width)

  let xMargin = 50;
  let yMargin = 50;
  let spacing = 20;
  let cols = 5;

  slotWidth = (canvasWidth - 2 * xMargin - (cols - 1) * spacing) / cols;
  slotHeight = (canvasHeight - 2 * yMargin - (floor(slots.length / cols) - 1) * spacing) / floor(slots.length / cols);
}
