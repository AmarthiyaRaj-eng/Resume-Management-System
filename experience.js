let count = 1;

function addExperience() {
  let container = document.getElementById("experience-container");

  let div = document.createElement("div");

  div.className = "experience-box";
  div.innerHTML = `
        <input
        type="text"
        name="company_name[]"
        placeholder="Company Name"
        required>

        <input
        type="text"
        name="job_title[]"
        placeholder="Job Title"
        required>

        <select name="employment_type[]">

            <option value="Full-time">Full-time</option>
            <option value="Part-time">Part-time</option>
            <option value="Internship">Internship</option>
            <option value="Freelance">Freelance</option>
            <option value="Contract">Contract</option>

        </select>

        <label>Start Date</label>

        <input
        type="date"
        name="start_date[]">

        <label>End Date</label>

        <input
        type="date"
        name="end_date[]"
        class="end-date">

        <label class="checkbox">

            <input
            type="checkbox"
            name="currently_working[${count}]"
            value="1"
            onchange="toggleEndDate(this)">

            Currently Working Here

        </label>

        <textarea
        name="description[]"
        placeholder="Describe your responsibilities, achievements and technologies used"></textarea>

        <button
        type="button"
        class="remove-btn"
        onclick="removeExperience(this)">

            Remove

        </button>

    `;

  container.appendChild(div);

  count++;
}

function removeExperience(button) {
  let boxes = document.querySelectorAll(".experience-box");

  if (boxes.length > 1) {
    button.parentElement.remove();

    updateCheckboxNames();
  }
}

function toggleEndDate(checkbox) {
  let box = checkbox.closest(".experience-box");

  let endDate = box.querySelector(".end-date");

  if (checkbox.checked) {
    endDate.value = "";
    endDate.disabled = true;
  } else {
    endDate.disabled = false;
  }
}

function updateCheckboxNames() {
  let checkboxes = document.querySelectorAll(
    "input[type='checkbox'][name^='currently_working']",
  );

  checkboxes.forEach(function (checkbox, index) {
    checkbox.name = `currently_working[${index}]`;
  });

  count = checkboxes.length;
}
