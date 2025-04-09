<script setup>
defineProps({
  ticket: {
    type: Object,
    required: true,
  },
});

const formatStatus = (status) => {
  const formatted = status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
  return formatted;
};

const statusClass = (status) => {
  switch (status) {
    case 'open':
      return 'badge bg-success';
    case 'in_progress':
      return 'badge bg-warning text-dark';
    case 'closed':
      return 'badge bg-secondary';
    default:
      return 'badge bg-light text-dark';
  }
};
</script>

<template>
  <transition name="modal-fade">
    <div
      class="modal fade show d-block"
      tabindex="-1"
      style="background-color: rgba(0, 0, 0, 0.6);"
      @click.self="$emit('close')"
    >
      <transition name="modal-slide">
        <div class="modal-dialog modal-lg modal-dialog-centered" v-if="ticket">
          <div class="modal-content shadow-lg rounded-4 border-0 animate__animated">
            <!-- Modal Header -->
            <div
              class="modal-header text-white py-4 px-5"
              style="background: linear-gradient(135deg, #007bff, #0056b3); border-top-left-radius: 1rem; border-top-right-radius: 1rem;"
            >
              <h4 class="modal-title d-flex align-items-center gap-3 fw-semibold">
                <i class="bi bi-exclamation-circle-fill fs-3"></i>
                Concern: <span class="text-white fs-8">{{ ticket.title }}</span>
              </h4>
              <button
                type="button"
                class="btn-close btn-close-white"
                @click="$emit('close')"
                title="Close"
              ></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body px-5 py-4 bg-light" style="max-height: 60vh; overflow-y: auto;">
              <!-- Category -->
              <div class="mb-4">
                <p class="mb-2 d-flex align-items-center gap-2">
                  <i class="bi bi-tag-fill text-primary fs-5"></i>
                  <strong class="text-secondary fw-bold fs-5">Category:</strong>
                  <span class="text-dark fs-5">
                  {{
                    ticket.category
                      .replace(/_/g, ' ')
                      .split(' ')
                      .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                      .join(' ')
                  }}
                </span>
                </p>
              </div>

              <!-- Description -->
              <div class="mb-4">
                <label class="d-flex align-items-center gap-2 text-secondary fw-bold fs-5">
                  <i class="bi bi-chat-text-fill text-primary fs-5"></i>
                  Description:
                </label>
                <p class="fs-5 text-dark mt-1 ms-4" style="white-space: pre-line;">
                  {{ ticket.description }}
                </p>
              </div>
            </div>

            <!--Footer -->
            <div
              class="modal-footer bg-light px-5 py-3"
              style="border-bottom-left-radius: 1rem; border-bottom-right-radius: 1rem;"
            >
                <small class="d-flex align-items-center gap-2 text-muted fs-8">
                  Created at: {{ new Date(ticket.created_at).toLocaleString() }}
                </small>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </transition>
</template>

<style scoped>
    .modal-fade-enter-active, .modal-fade-leave-active {
        transition: opacity 0.3s ease;
    }
    .modal-fade-enter-from, .modal-fade-leave-to {
        opacity: 0;
    }

    .modal-slide-enter-active, .modal-slide-leave-active {
        transition: all 0.3s ease;
    }
    .modal-slide-enter-from, .modal-slide-leave-to {
        transform: translateY(-20px);
        opacity: 0;
    }

    .animate__animated {
        animation: fadeInUp 0.4s;
    }

    @keyframes fadeInUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
