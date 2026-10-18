<div class="bg-white min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-[3rem] max-w-6xl w-[550px] md:flex-row overflow-hidden ">
        <div class="flex flex-col items-center">
            <img src="<?= base_url('assets/logo/logo-hitam.png') ?>" alt="logo guci" class="w-[200px]">
            <div class="w-[300px] mt-5 flex flex-col justify-start font-semibold">
                <?php if ($this->session->flashdata('message', 'error')) : ?>
                    <?= $this->session->flashdata('message', 'error'); ?>
                <?php endif; ?>
            </div>
            <form class="md:w-[400px] mt-5 space-y-6" method="post" action="<?= base_url('CAuth') ?>">
                <div class="relative">
                    <input class="w-full border border-gray-300 rounded-full py-3 px-5 pr-12 text-sm text-gray-500 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-300"
                        placeholder="Email"
                        type="text"
                        name="email" />
                    <i aria-hidden="true" class="fas fa-envelope absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 text-sm">
                    </i>
                    <span style="color: red;"><?php echo form_error('email'); ?></span>

                </div>

                <div class="relative">
                    <input id="password"
                        class="w-full border border-gray-300 rounded-full py-3 px-5 pr-12 text-sm text-gray-500 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-300"
                        placeholder="Password"
                        type="password"
                        name="password" />

                    <i id="togglePassword"
                        aria-hidden="true"
                        class="fas fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 text-sm cursor-pointer">
                    </i>

                    <span style="color: red;"><?php echo form_error('password'); ?></span>
                </div>

                <div class="flex items-center justify-between text-xs text-gray-600 mb-8">
                    <label class="flex items-center gap-2 select-none">
                        <input class="w-3.5 h-3.5 border border-gray-300 rounded-sm" type="checkbox" />
                        <span class="font-normal">
                            Remember for 30 days
                        </span>
                    </label>
                    <!-- <a class="text-gray-400 hover:text-gray-600" href="#">
                        Forgot password?
                    </a> -->
                </div>
                <button class="w-full bg-[#002347] text-white rounded-full py-2 text-sm font-normal transition" type="submit">
                    Log In
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        // Toggle the type attribute
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Toggle the icon class
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>