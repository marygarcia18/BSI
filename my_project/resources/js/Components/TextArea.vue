<script setup>
defineProps(['id', 'class', 'modelValue', 'rows']);
defineEmits(['update:modelValue']);
</script>

<template>
    <textarea
        :id="id"
        :class="class"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :rows="rows"
    ></textarea>
</template>
