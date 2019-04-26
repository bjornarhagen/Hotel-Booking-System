window.addEventListener("load", () => {
    let passwordCheckInputShowing = false;

    const emailInput = document.querySelector("#user-update-form-email");
    const passworInput = document.querySelector("#user-update-form-password");
    const passwordCheckInput = document.querySelector(
        "#user-update-form-password-current"
    );

    // Make sure we have all the input elements
    if (!passwordCheckInput || !emailInput || !passworInput) {
        return;
    }

    const passwordCheckInputWrapper = passwordCheckInput.parentNode.parentNode;
    const emailInputOriginalValue = emailInput.value;

    emailInput.addEventListener("input", userFormProtectedInputChange);
    passworInput.addEventListener("input", userFormProtectedInputChange);

    function userFormProtectedInputChange() {
        if (passwordCheckInputShowing) {
            if (
                passworInput.value.length === 0 &&
                emailInput.value === emailInputOriginalValue
            ) {
                passwordCheckInputShowing = false;
                passwordCheckInputWrapper.classList.add("hidden");
                passwordCheckInput.removeAttribute("required");
            }
        } else {
            passwordCheckInputShowing = true;
            passwordCheckInputWrapper.classList.remove("hidden");
            passwordCheckInput.setAttribute("required", "");
        }
    }
});
