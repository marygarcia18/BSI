<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{ isLogin ? 'Login' : 'Register' }}</div>
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <template v-if="!isLogin">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" v-model="form.name" class="form-control" required>
                                </div>
                            </template>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" v-model="form.email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" v-model="form.password" class="form-control" required>
                            </div>
                            <template v-if="isLogin">
                                <div class="mb-3 form-check">
                                    <input type="checkbox" v-model="form.remember" class="form-check-input" id="remember">
                                    <label class="form-check-label" for="remember">Remember Me</label>
                                </div>
                            </template>
                            <template v-if="!isLogin">
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" v-model="form.password_confirmation" class="form-control" required>
                                </div>
                            </template>
                            <button type="submit" class="btn btn-primary">{{ isLogin ? 'Login' : 'Register' }}</button>
                        </form>
                        <div class="mt-3 text-center">
                            <button class="btn btn-link" @click="toggleAuthMode">
                                {{ isLogin ? 'Need an account? Register' : 'Already have an account? Login' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

export default {
    setup() {
        const isLogin = ref(true);
        const form = useForm({
            name: '',
            email: '',
            password: '',
            // password_confirmation: '',
            remember: false
        });

        // function submit() {
        //     if (isLogin.value) {
        //         form.post('/login');
        //     } else {
        //         form.post('/register');
        //     }
        // }

        // function submit() {
        //     form.post('/login', {
        //         onSuccess: (response) => {
        //             if (response.props.redirect) {
        //                 window.location.href = response.props.redirect; // Redirect to Dashboard
        //             }
        //         },
        //         onError: (errors) => {
        //             alert(errors.message || "Login failed");
        //         }
        //     });
        // }

        function submit() {
            form.post('/dashboard', {
                onSuccess: (response) => {
                    if (response.props.token) {
                        localStorage.setItem('auth_token', response.props.token);
                        // Redirect to dashboard
                        window.location.href = response.props.redirect; 
                    }
                },
                onError: (errors) => {
                    alert(errors.message || "Login failed");
                }
            });
        }



        function toggleAuthMode() {
            isLogin.value = !isLogin.value;
            form.name = '';
            form.email = '';
            form.password = '';
            form.password_confirmation = '';
            form.remember = false;
        }

        return { form, submit, isLogin, toggleAuthMode };
    }
}
</script>

<style scoped>
.container {
    margin-top: 50px;
}
</style>