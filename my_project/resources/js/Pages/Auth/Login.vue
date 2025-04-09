<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-blue">
        <div class="row w-100 shadow rounded overflow-hidden" style="max-width: 1000px;">
            <!-- Image Column -->
            <div class="col-md-6 d-none d-md-block p-0">
                <img
                    src="https://img.freepik.com/free-vector/flat-design-online-ticket-illustration_23-2151089471.jpg?t=st=1743846487~exp=1743850087~hmac=82ec02db35074609590d78d1380089c49de729580162406591af2c6cf2299146&w=900"
                    class="img-fluid h-100 w-100 object-fit-cover"
                />
            </div>

            <!-- Login Form Column -->
            <div class="col-12 col-md-6 bg-white p-4 p-md-5 d-flex align-items-center ">
                <div class="w-100">
                    <h1 class="mb-3" style="font-family: 'Merriweather', serif; font-size: 2rem;">Effortless Ticketing, Seamless Support</h1>
                    <!-- <p class="mb-4 text-muted" style="font-family: 'Poppins', sans-serif;">
                        Login to submit and track your concern tickets effortlessly.
                    </p> -->

                    <form @submit.prevent="submit" style="font-family: 'Poppins', sans-serif;">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input
                                id="email"
                                type="email"
                                class="form-control"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="username"
                            />
                            <div v-if="form.errors.email" class="text-danger mt-1">{{ form.errors.email }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input
                                id="password"
                                type="password"
                                class="form-control"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                            />
                            <div v-if="form.errors.password" class="text-danger mt-1">{{ form.errors.password }}</div>
                        </div>

                        <div class="mb-3 form-check">
                            <input
                                id="remember"
                                type="checkbox"
                                class="form-check-input"
                                v-model="form.remember"
                            />
                            <label for="remember" class="form-check-label">Remember me</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <Link
                                :href="route('password.request')"
                                class="text-decoration-underline small"
                            >
                                Forgot your password?
                            </Link>
                        </div>

                        <!-- <div class="d-flex justify-content-between align-items-center mb-3">
                            <Link
                                :href="route('register')"
                                class="text-decoration-underline small"
                            >
                                Already have an account?
                            </Link>
                        </div> -->

                        <div>
                            <button class="btn btn-primary w-100" :disabled="form.processing">
                                Log in
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    @import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Poppins:wght@300;400;500&display=swap');

    .object-fit-cover {
        object-fit: cover;
        height: 100%;
    }

    .bg-blue {
        background-color: #badbff;
    }
    .small {
        color: grey;
    }
    .small:hover {
        color: #007bff;
        transition: color 0.3s ease;
    }
</style>
