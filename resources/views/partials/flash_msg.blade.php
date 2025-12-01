@if (session('message'))
    <div class="msg fixed top-[10px] left-[50%] transform -translate-x-1/2 bg-black text-[limegreen] border border-[limegreen] text-lg transition duration-300 rounded-xl py-1 px-3 opacity-0 -translate-y-[100px]">{{ session('message') }}</div>
    @php
        session()->forget('message'); // reset after showing once
    @endphp
@endif

<script>
    // show success msg nicely and then hide
    const successMsg = document.querySelector('.msg');
    setTimeout(() => {
        successMsg.classList.remove('opacity-0');
        successMsg.classList.remove('-translate-y-[100px]');
    }, 300)
    setTimeout(() => {
        successMsg.classList.add('opacity-0');
        successMsg.classList.add('-translate-y-[100px]');
    }, 5000)
    setTimeout(() => { successMsg.remove(); }, 5500)
</script>