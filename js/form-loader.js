document.addEventListener("DOMContentLoaded", function () {
  const formContainer = document.getElementById("formContainer");
  const radios = document.querySelectorAll("input[name='forms']");
  const params = new URLSearchParams(window.location.search);
  const editId = params.get("id");

  let currentScript = null;
  /** False after first initializeFormLoader() completes — avoids clearing edit on programmatic radio set */
  let formLoaderInitializing = true;

  function stripEditIdFromUrl() {
    const url = new URL(window.location.href);
    url.searchParams.delete("id");
    const q = url.searchParams.toString();
    const next = url.pathname + (q ? "?" + q : "") + url.hash;
    history.replaceState(null, "", next);
  }

  function resetEditContext() {
    delete window.__editFormData;
    stripEditIdFromUrl();
  }

  function loadForm(type) {
    /* remove previous form */
    formContainer.innerHTML = "";

    /* remove previous form JS */
    if (currentScript) {
      currentScript.remove();
      currentScript = null;
    }

    let formFile = "";
    let jsFile = "";
    let initFunction = "";
    let formId = "";

    if (type === "Immovable") {
      formFile = "components/form1.php";
      jsFile = "js/form1.js";
      initFunction = "initForm1";
      formId = "form1";
    }

    if (type === "Movable") {
      formFile = "components/form2.php";
      jsFile = "js/form2.js";
      initFunction = "initForm2";
      formId = "form2";
    }

    fetch(formFile)
      .then((response) => response.text())
      .then((html) => {
        /* insert form HTML */
        formContainer.innerHTML = html;

        /* load form JS */
        const script = document.createElement("script");
        script.src = jsFile;

        script.onload = function () {
          requestAnimationFrame(() => {
            const form = document.getElementById(formId);

            if (!form) {
              console.error("Form not found after load:", formId);
              return;
            }

            // Init form logic
            if (typeof window[initFunction] === "function") {
              window[initFunction]();
            }

            const tinyPromise =
              typeof initTinyMCE === "function"
                ? initTinyMCE()
                : Promise.resolve();

            Promise.resolve(tinyPromise)
              .catch(() => {})
              .finally(() => {
                if (typeof initDynamicRows === "function") {
                  initDynamicRows(formId);
                }
                // Edit flow: fill main fields + one .property-block per API item (properties or propertyDetails)
                if (
                  formId === "form1" &&
                  typeof hydrateForm1ForEdit === "function"
                ) {
                  hydrateForm1ForEdit();
                } else if (
                  formId === "form2" &&
                  typeof hydrateForm2ForEdit === "function"
                ) {
                  hydrateForm2ForEdit();
                }
              });
          });
        };

        document.body.appendChild(script);
        currentScript = script;
      })
      .catch((err) => {
        console.error("Form loading error:", err);
      });
  }

  radios.forEach((radio) => {
    radio.addEventListener("change", function () {
      if (!this.checked) return;
      if (!formLoaderInitializing) {
        resetEditContext();
      }
      loadForm(this.value);
    });
  });

  async function initializeFormLoader() {
    try {
      if (editId) {
        try {
          const res = await fetch("api/getDataById.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ id: editId }),
          });

          const json = await res.json();

          if (json.success && json.data) {
            window.__editFormData = json.data;
            const ft = String(json.data.form_type || "").toLowerCase();
            const selectedType = ft === "movable" ? "Movable" : "Immovable";
            const selectedRadio = document.querySelector(
              `input[name='forms'][value='${selectedType}']`,
            );

            if (selectedRadio) {
              selectedRadio.checked = true;
            }

            loadForm(selectedType);
            return;
          }
          delete window.__editFormData;
        } catch (err) {
          console.error("Failed to load edit form data:", err);
          delete window.__editFormData;
        }
      }

      /* default load */
      const defaultForm = document.querySelector(
        "input[name='forms']:checked",
      ).value;
      loadForm(defaultForm);
    } finally {
      formLoaderInitializing = false;
    }
  }

  initializeFormLoader();
});
