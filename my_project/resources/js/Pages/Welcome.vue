<script setup>
import { Head, Link } from '@inertiajs/vue3';
import 'bootstrap';

defineProps({
    canLogin: {
        type: Boolean,
        default: true,
    },
    canRegister: {
        type: Boolean,
        default: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome">
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Poppins&display=swap" rel="stylesheet" />
    </Head>

    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-blue text-dark">
        <div class="row w-100 shadow rounded overflow-hidden" style="max-width: 1000px;">
            <!-- Image Column -->
            <div class="col-md-6 d-none d-md-block p-0">
                <img
                    src="https://img.freepik.com/free-vector/flat-design-online-ticket-illustration_23-2151089471.jpg?t=st=1743846487~exp=1743850087~hmac=82ec02db35074609590d78d1380089c49de729580162406591af2c6cf2299146&w=900"
                    class="img-fluid h-100 w-100 object-fit-cover"
                    @error="handleImageError"
                />
            </div>

            <!-- Content Column -->
            <div class="col-12 col-md-6 p-4 p-md-5 d-flex align-items-center bg-white">
                <div class="w-100 text-center text-md-start">
                    <h1 class="mb-3" style="font-family: 'Merriweather', serif; font-size: 2.3rem;" >Effortless Ticketing, Seamless Support</h1>
                    <p style="font-family: 'Poppins', sans-serif;">
                        Submit your concerns and let our team handle the rest with an efficient and user-friendly ticketing system.
                    </p>

                    <div class="mt-4">
                        <template v-if="canLogin">
                            <Link :href="route('login')" class="btn btn-primary me-2 mb-2">Login</Link>
                        </template>
                        <template v-if="canRegister">
                            <Link :href="route('register')" class="btn btn-outline-primary mb-2">Register</Link>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .object-fit-cover {
        object-fit: cover;
        height: 100%;
    }
    .bg-blue {
        background-color: #badbff;
    }
    .bg-white {
        background-color: #f7f7f7;
    }
</style>
