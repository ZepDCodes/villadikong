function toggleReason(select) {
    const form = select.closest(".update-form");
    const reasonField = form.querySelector(".reason-field");
    if (select.value === "Cancelled") {
        reasonField.style.display = "inline-block";
        reasonField.required = true;
    } else {
        reasonField.style.display = "none";
        reasonField.required = false;
        reasonField.value = ""; // clear old reason
    }
}