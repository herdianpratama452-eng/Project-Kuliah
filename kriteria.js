document
  .getElementById("formKriteria")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const data = {};
    new FormData(this).forEach((value, key) => {
      if (!data[key]) data[key] = [];
      data[key].push(value);
    });

    localStorage.setItem("kriteria", JSON.stringify(data));
    window.location.href = "bobot_kriteria.html";
  });
