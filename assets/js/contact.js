document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("contact-form");
  const banner = document.getElementById("form-banner");
  const submitButton = form.querySelector("button[type='submit']");
  const btnText = document.getElementById("btn-text");
  const btnSpinner = document.getElementById("btn-spinner");

  function showBanner(message, bgColor) {
    banner.textContent = message;
    banner.style.backgroundColor = bgColor;
    banner.style.color = "#fff";
    banner.style.display = "block";
    banner.style.opacity = 1;

    setTimeout(() => {
      banner.style.opacity = 0;
      setTimeout(() => banner.style.display = "none", 500);
    }, 4000);
  }

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    // Show spinner
    btnText.style.display = "none";
    btnSpinner.style.display = "inline-block";
    submitButton.disabled = true;

    const formData = new FormData(form);

    fetch("https://formspree.io/f/mdkbojlk", {
      method: "POST",
      body: formData,
      headers: { 'Accept': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
      if (data.ok || data.success) {
        showBanner("✅ Message sent successfully!", "green");
        form.reset();
      } else {
        showBanner("❌ Oops! There was a problem sending your message.", "red");
      }
    })
    .catch(error => {
      console.error("Form submission error:", error);
      showBanner("❌ Oops! There was a problem sending your message.", "red");
    })
    .finally(() => {
      btnText.style.display = "inline";
      btnSpinner.style.display = "none";
      submitButton.disabled = false;
    });
  });
});