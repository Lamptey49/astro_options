<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white/5 backdrop-blur p-8 rounded-2xl border border-white/10 shadow-xl">

        <h2 class="text-3xl font-bold text-center mb-2">
            Welcome Back
        </h2>
        <p class="text-center text-gray-400 mb-8">
            Login to your account
        </p>

        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            <!-- Email -->
            <div class="mb-5">
                <label class="block mb-2 text-sm">Email Address</label>
                <input type="email" name="email" required autofocus
                       class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label class="block mb-2 text-sm">Password</label>
                <input type="password" name="password" required
                       class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <!-- Remember -->
            <div class="flex items-center justify-between mb-6 text-sm">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="accent-indigo-500">
                    Remember me
                </label>
                <a href="<?php echo e(route('password.request')); ?>" class="text-indigo-400 hover:underline">
                    Forgot password?
                </a>
            </div>

            <!-- Submit -->
            <button class="w-full py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-500 font-semibold hover:opacity-90">
                Login
            </button>
        </form>

        <p class="text-center text-gray-400 mt-8 text-sm">
            Don’t have an account?
            <a href="<?php echo e(route('register')); ?>" class="text-indigo-400 hover:underline">
                Create one
            </a>
        </p>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Phinehas KwakuFix\Herd\crypto-invest\resources\views/auth/login.blade.php ENDPATH**/ ?>