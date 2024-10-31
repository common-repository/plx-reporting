/**
 * Copy JSON to Clipboard
 */
const copyJsonToClipboardButton = document.querySelector(
  "#plx-reporting-json-copy"
);

if (copyJsonToClipboardButton) {
  copyJsonToClipboardButton.addEventListener("click", function (e) {
    const json = document.querySelector("#plx-reporting-json").innerHTML;
    navigator.clipboard.writeText(json);

    const label = e.target.innerText;
    const buttonWidth = e.target.offsetWidth;

    e.target.style.width = buttonWidth;
    e.target.innerText = "Copied!";

    setTimeout(function () {
      e.target.innerText = label;
      e.target.style.width = "auto";
    }, 1500);
  });
}

/**
 * Download JSON as file
 */
const downloadJsonToClipboardButton = document.querySelector(
  "#plx-reporting-json-download"
);

if (downloadJsonToClipboardButton) {
  const json = JSON.parse(
    document.querySelector("#plx-reporting-json").innerHTML
  );
  const dataStr =
    "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(json));

  downloadJsonToClipboardButton.setAttribute("href", dataStr);
}
