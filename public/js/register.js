
function validate_form ( )
{
    if (document.registration.password.value.length < 4)
    {
        alert("Пароль слишком короткий")
        return false
    }
    if (document.registration.password.value !== document.registration.password2.value)
    {
        alert("Пароли не совпадают")
        return false
    }
    return true;
}
