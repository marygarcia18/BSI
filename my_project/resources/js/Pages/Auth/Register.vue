<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Register" />

    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-blue">
        <div class="row w-100 shadow rounded overflow-hidden" style="max-width: 900px; width: 100%;">
            <!-- Image Column -->
            <div class="col-md-6 d-none d-md-block p-0">
                <img
                    src="https://img.freepik.com/free-vector/flat-design-online-ticket-illustration_23-2151089471.jpg?t=st=1743846487~exp=1743850087~hmac=82ec02db35074609590d78d1380089c49de729580162406591af2c6cf2299146&w=900"
                    class="img-fluid h-100 w-100 object-fit-cover"
                    style="max-height: 100vh;"
                />
            </div>

            <!-- Register Form Column -->
            <div class="col-12 col-md-6 p-4 p-md-5 d-flex align-items-center justify-content-center bg-white" style="max-height: 100vh; overflow-y: auto;">
                <div class="w-100 text-center text-md-start" style="max-width: 400px; width: 100%;">
                    <h1 class="mb-3" style="font-family: 'Merriweather', serif; font-size: 2rem;">
                        Create Your Account
                    </h1>

                    <form @submit.prevent="submit" style="font-family: 'Poppins', sans-serif;">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input
                                id="name"
                                type="text"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                                class="form-control"
                            />
                            <div v-if="form.errors.name" class="text-danger mt-1">{{ form.errors.name }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input
                                id="email"
                                type="email"
                                v-model="form.email"
                                required
                                autocomplete="username"
                                class="form-control"
                            />
                            <div v-if="form.errors.email" class="text-danger mt-1">{{ form.errors.email }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input
                                id="password"
                                type="password"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                                class="form-control"
                            />
                            <div v-if="form.errors.password" class="text-danger mt-1">{{ form.errors.password }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input
                                id="password_confirmation"
                                type="password"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                                class="form-control"
                            />
                            <div v-if="form.errors.password_confirmation" class="text-danger mt-1">
                                {{ form.errors.password_confirmation }}
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <Link
                                :href="route('login')"
                                class="text-decoration-underline small"
                            >
                                Already registered?
                            </Link>
                        </div>

                        <div>
                            <button class="btn btn-primary w-100" :disabled="form.processing">
                                Register
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

    .col-md-6 {
        max-height: 100vh;
        overflow-y: auto; 
    }

    .small:hover {
        color: #007bff; 
        transition: color 0.3s ease;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 0 15px;
        }

        .row {
            width: 100%;
        }

        .col-md-6 {
            padding: 0;
        }

        .col-12 {
            padding: 0;
        }

        .w-100 {
            width: 100%;
        }
    }
</style>
