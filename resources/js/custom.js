const showAlert = (type, text, duration = 3000, callback = null) => {
    const bgColor = type === 'success' ? '#00C48C' : (type === 'error' ? '#ed3d3d' : '#9ea9b4');
    Toastify.multiple = false;
    // hide existing
    document.querySelectorAll('.toastify').forEach((el) => el.remove());

    Toastify({
        text: text,
        duration: duration,
        close: true,
        gravity: 'top',
        position: "right",
        stopOnFocus: true,
        style: {
            background: bgColor,
        },
        callback: callback
    }).showToast();
}

const getToken = () => {
    const metaToken = document.querySelector('meta[name="csrf-token"]');
    return metaToken.getAttribute('content');
}

export {
    showAlert, getToken
}
