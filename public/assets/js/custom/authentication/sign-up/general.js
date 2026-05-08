    const step1 = document.getElementById('step_1');
    const step2 = document.getElementById('step_2');
    const step3 = document.getElementById('step_3');

    function showStep(n) {
        step1.style.display = n === 1 ? '' : 'none';
        step2.style.display = n === 2 ? '' : 'none';
        step3.style.display = n === 3 ? '' : 'none';
        window.scrollTo(0, 0);
    }

    document.querySelectorAll('.role-radio').forEach(radio => {
        radio.addEventListener('change', function () {
            document.querySelectorAll('.role-card').forEach(c => {
                c.classList.remove('border-primary', 'bg-light-primary');
                c.classList.add('border-secondary', 'bg-transparent');
            });
            document.querySelectorAll('.role-icon-wrap').forEach(i => {
                i.classList.remove('bg-primary'); i.classList.add('bg-secondary');
            });
            document.querySelectorAll('.role-icon-wrap i').forEach(i => {
                i.classList.remove('text-white'); i.classList.add('text-muted');
            });
            document.querySelectorAll('.role-label').forEach(l => {
                l.classList.remove('text-primary'); l.classList.add('text-muted');
            });
            const card = this.nextElementSibling;
            card.classList.add('border-primary', 'bg-light-primary');
            card.classList.remove('border-secondary', 'bg-transparent');
            card.querySelector('.role-icon-wrap').classList.replace('bg-secondary', 'bg-primary');
            card.querySelector('.role-icon-wrap i').classList.replace('text-muted', 'text-white');
            card.querySelector('.role-label').classList.replace('text-muted', 'text-primary');
        });
    });

    document.getElementById('btn_next_1').addEventListener('click', function () {
        const name  = document.querySelector('[name="name"]').value.trim();
        const email = document.querySelector('[name="email"]').value.trim();
        const phone = document.querySelector('[name="phone"]').value.trim();
        const role  = document.querySelector('.role-radio:checked')?.value;

        if (!name || !email || !phone) {
            alert('Lütfen tüm alanları doldurun.');
            return;
        }

        if (role === 'seller') {
            showStep(2);
        } else {
            document.getElementById('step_label').textContent = 'Adım 2 / 2';
            showStep(3);
        }
    });

    document.getElementById('btn_back_2').addEventListener('click', () => showStep(1));

    document.getElementById('btn_next_2').addEventListener('click', function () {
        const tax  = document.querySelector('[name="tax_number"]').value.trim();
        const iban = document.querySelector('[name="iban"]').value.trim();

        if (!tax || !iban) {
            alert('Vergi numarası ve IBAN zorunludur.');
            return;
        }
        document.getElementById('step_label').textContent = 'Adım 3 / 3';
        showStep(3);
    });

    document.getElementById('btn_back_3').addEventListener('click', function () {
        const role = document.querySelector('.role-radio:checked')?.value;
        showStep(role === 'seller' ? 2 : 1);
    });

    document.getElementById('kt_sign_up_form').addEventListener('submit', function (e) {
        const pass  = document.getElementById('password').value;
        const passC = document.getElementById('password_confirmation').value;
        const terms = document.getElementById('terms_check').checked;
        let valid = true;

        const mismatch = document.getElementById('password_mismatch_error');
        if (!pass || !passC || pass !== passC) {
            mismatch.style.display = '';
            valid = false;
        } else {
            mismatch.style.display = 'none';
        }

        const termsErr = document.getElementById('terms_error');
        if (!terms) {
            termsErr.style.display = '';
            valid = false;
        } else {
            termsErr.style.display = 'none';
        }

        if (!valid) { e.preventDefault(); return; }

        const btn = document.getElementById('kt_sign_up_submit');
        btn.setAttribute('data-kt-indicator', 'on');
        btn.disabled = true;
    });