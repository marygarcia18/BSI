<script setup>
import { useForm, router } from '@inertiajs/vue3';

    const props = defineProps({
        ticket: {
            type: Object,
            required: true
        }
    });

    const form = useForm({
        title: props.ticket.title,
        description: props.ticket.description,
        status: props.ticket.status,
        priority: props.ticket.priority,
    });

    const submit = () => {
        form.put(`/tickets/${props.ticket.id}`, {
            onSuccess: () => {
                router.visit('/dashboard');
            }
        });
    };

    const goBack = () => {
        router.get('/dashboard');
    };
</script>

<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h1 class="h5 mb-0">Edit Ticket</h1>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input 
                                    v-model="form.title" 
                                    type="text"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.title }"
                                />
                                <div v-if="form.errors.title" class="invalid-feedback">
                                    {{ form.errors.title }}
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea 
                                    v-model="form.description" 
                                    rows="4"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.description }"
                                ></textarea>
                                <div v-if="form.errors.description" class="invalid-feedback">
                                    {{ form.errors.description }}
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select 
                                    v-model="form.status" 
                                    class="form-select"
                                    :class="{ 'is-invalid': form.errors.status }"
                                >
                                    <option value="Open">Open</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Resolved">Resolved</option>
                                </select>
                                <div v-if="form.errors.status" class="invalid-feedback">
                                    {{ form.errors.status }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Priority</label>
                                <select 
                                    v-model="form.priority" 
                                    class="form-select"
                                    :class="{ 'is-invalid': form.errors.priority }"
                                >
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                                <div v-if="form.errors.priority" class="invalid-feedback">
                                    {{ form.errors.priority }}
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button 
                                    type="button"
                                    @click="goBack"
                                    class="btn btn-secondary me-2"
                                >
                                    Back
                                </button>
                                <button 
                                    type="submit"
                                    :disabled="form.processing"
                                    class="btn btn-primary"
                                >
                                    {{ form.processing ? 'Updating...' : 'Update Ticket' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


