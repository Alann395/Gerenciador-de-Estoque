<div x-data="{ show: false }"
     x-show="show"
     x-transition.opacity
     class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50">

     <div class="loader"></div>

</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    Livewire?.hook("message.sent", () => document.querySelector('[x-data]').__x.$data.show = true);
    Livewire?.hook("message.processed", () => document.querySelector('[x-data]').__x.$data.show = false);
});
</script>
