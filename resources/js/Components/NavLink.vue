<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'tw-inline-flex tw-items-center tw-px-1 tw-pt-1 tw-border-b-2 tw-border-indigo-400 tw-text-sm tw-font-medium tw-leading-5 tw-text-gray-900 tw-focus:tw-outline-none tw-focus:tw-border-indigo-700 tw-transition tw-duration-150 tw-ease-in-out'
        : 'tw-inline-flex tw-items-center tw-px-1 tw-pt-1 tw-border-b-2 tw-border-transparent tw-text-sm tw-font-medium tw-leading-5 tw-text-gray-500 tw-hover:tw-text-gray-700 tw-hover:tw-border-gray-300 tw-focus:outline-none tw-focus:text-gray-700 tw-focus:border-gray-300 tw-transition tw-duration-150 tw-ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
