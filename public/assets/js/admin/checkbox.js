$(document).ready(function () {

    const userCapabilities = document.querySelectorAll('.capability-checkbox')
    if (userCapabilities) {

        const hiddenCapabilities = crud.field('capabilities')
        let initCap = hiddenCapabilities.input.value.split(',')
        initCap.forEach(val => {
            console.log(val)
            $(".capability-checkbox[value='" + val + "']").prop("checked", true)
        })
        let cap = []
        userCapabilities.forEach(el => {
            el.addEventListener('change', (e) => {
                console.log('trig')
                const val = parseInt(e.target.value)
                if (e.target.checked && !cap.includes(val)) {
                    cap.push(val)
                } else {
                    cap = cap.filter(function (item) {
                        return item !== val;
                    });
                }

                cap.sort()
                hiddenCapabilities.input.value = cap
            })
        });
    }
})