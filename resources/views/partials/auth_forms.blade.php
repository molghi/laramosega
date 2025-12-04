<div class="forms flex gap-8 p-8">
  <!-- Signup Form -->
  <div class="flex-1">
    <form action="{{ route('user.signup') }}" method="POST" class="signup-form transition duration-300 bg-gray-800 p-6 rounded shadow space-y-4 text-white">
        @csrf
        <h2 class="text-2xl text-center font-bold">Sign Up</h2>
        <input name="email" type="email" autofocus placeholder="Email" class="w-full p-2 border border-gray-600 rounded bg-gray-700 text-white">
        <input name="password" type="password" placeholder="Password" class="w-full p-2 border border-gray-600 rounded bg-gray-700 text-white">
        <input name="password_confirmation" type="password" placeholder="Repeat Password" class="w-full p-2 border border-gray-600 rounded bg-gray-700 text-white">
        <button type="submit" class="w-full bg-blue-600 py-2 rounded hover:bg-blue-700">Sign Up</button>
    </form>
  {{-- output errors --}}
  @error ('email')
    <div class="text-sm text-[red] border border-[red] rounded-md p-3 mt-4">{{ $message }}</div>
  @enderror
  @error ('password')
    <div class="text-sm text-[red] border border-[red] rounded-md p-3 mt-4">{{ $message }}</div>
  @enderror
  </div>

  <!-- Login Form -->
  <div class="flex-1">
    <form action="{{ route('user.login') }}" method="POST" class="login-form transition duration-300 opacity-50 bg-gray-800 p-6 rounded shadow space-y-4 text-white">
        @csrf
        <h2 class="text-2xl text-center font-bold">Login</h2>
        <input name="email_login" type="email" placeholder="Email" class="w-full p-2 border border-gray-600 rounded bg-gray-700 text-white">
        <input name="password_login" type="password" placeholder="Password" class="w-full p-2 border border-gray-600 rounded bg-gray-700 text-white">
        <button type="submit" class="w-full bg-green-600 py-2 rounded hover:bg-green-700">Login</button>
    </form>
  {{-- output errors --}}
  @error ('email_login')
    <div class="text-sm text-[red] border border-[red] rounded-md p-3 mt-4">{{ $message }}</div>
  @enderror
  @error ('password_login')
    <div class="text-sm text-[red] border border-[red] rounded-md p-3 mt-4">{{ $message }}</div>
  @enderror
  </div>

</div>


<script>
    // hover over form and highlight it
    document.querySelector('.forms').addEventListener('mouseover', function (e) {
        if (!e.target.closest('form')) return;
        document.querySelectorAll('.forms form').forEach(x => x.classList.add('opacity-50')); // make dimmed
        e.target.closest('form').classList.remove('opacity-50'); // highlight
        e.target.closest('form').querySelector('input').focus(); // focus 1st input
    });
</script>