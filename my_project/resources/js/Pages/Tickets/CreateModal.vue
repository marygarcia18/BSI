<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const emit = defineEmits(['close']);

const form = useForm({
    title: '',
    description: '',
    category: 'tech_issues',
});

// const submit = () => {
//     form.post(route('tickets.store'), {
//         onSuccess: () => {
//             router.visit('/dashboard');
//             form.reset();
//             emit('close');
//         }
//     });
// };

const submit = () => {
    form.post(route('tickets.store'), {
        onSuccess: () => {
            form.reset();
            emit('close');
            Swal.fire({
                title: 'Success!',
                text: 'Your ticket has been created successfully.',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then(() => {
                router.visit('/dashboard');
            });
        }
    });
};

</script>

<template>
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.6);">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg rounded-4 border-0">
                <div class="modal-header bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-semibold">
                        <i class="bi bi-pencil-square me-2"></i>
                        Create New Ticket
                    </h5>
                    <button type="button" class="btn-close btn-close-white" @click="$emit('close')"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    <form @submit.prevent="submit">
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">Title</label>
                            <input
                                id="title"
                                type="text"
                                class="form-control shadow-sm"
                                v-model="form.title"
                                required
                                :class="{ 'is-invalid': form.errors.title }"
                            />
                            <div v-if="form.errors.title" class="invalid-feedback">
                                {{ form.errors.title }}
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea
                                id="description"
                                class="form-control shadow-sm"
                                v-model="form.description"
                                required
                                rows="4"
                                :class="{ 'is-invalid': form.errors.description }"
                            ></textarea>
                            <div v-if="form.errors.description" class="invalid-feedback">
                                {{ form.errors.description }}
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category" class="form-label fw-semibold">Category</label>
                            <select
                                id="category"
                                class="form-select shadow-sm"
                                v-model="form.category"
                                required
                                :class="{ 'is-invalid': form.errors.category }"
                            >
                                <option value="tech_issues">🛠 Tech Issues</option>
                                <option value="billing_concerns">💳 Billing Concerns</option>
                                <option value="general_inquiry">❓ General Inquiry</option>
                            </select>
                            <div v-if="form.errors.category" class="invalid-feedback">
                                {{ form.errors.category }}
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end mt-4">
                            <button
                                type="button"
                                class="btn btn-outline-danger
                                
                                 me-2"
                                @click="$emit('close')"
                            >
                                <i class="bi bi-x-circle me-1"></i> Cancel
                            </button>
                            <button
                                type="submit"
                                class="btn btn-primary d-flex align-items-center"
                                :disabled="form.processing"
                            >
                                <i class="bi bi-send-check me-2"></i>
                                {{ form.processing ? 'Creating...' : 'Create Ticket' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.modal-content {
    animation: fadeInUp 0.3s ease;
}

@keyframes fadeInUp {
    from {
        transform: translateY(40px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

input:focus,
textarea:focus,
select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}
</style>
