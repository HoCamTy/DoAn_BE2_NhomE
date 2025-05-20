<!-- resources/views/ratings/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="rating-container">
        <div class="back-button">
            <a href="{{ route('home') }}" class="btn btn-secondary">&larr; Quay Lại</a>
        </div>
        <h2 class="text-center">Đánh Giá Dịch Vụ</h2>

        <form action="{{ route('ratings.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="customer" class="form-label">Khách Hàng</label>
                <select id="customer" name="customer_id" class="form-select" required>
                    <option value="" disabled selected>Chọn Khách Hàng</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Đánh Giá Dịch Vụ</label>
                <div class="star-rating">
                    @for ($i = 5; $i >= 1; $i--)
                        <input type="radio" name="service_rating" value="{{ $i }}" id="star{{ $i }}" class="rating-input">
                        <label for="star{{ $i }}" class="star-label">&#9733;</label>
                    @endfor
                </div>
            </div>

            <div class="mb-3">
                <label for="comments" class="form-label">Nhận Xét</label>
                <textarea class="form-control" name="comments" rows="4" placeholder="Chia sẻ cảm nhận..." required></textarea>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Gửi Đánh Giá</button>
            </div>
        </form>

        <div class="footer-text text-center mt-3">
            <p>Cảm ơn bạn đã chia sẻ đánh giá!</p>
        </div>
    </div>
</div>

<!-- Gắn JS hiệu ứng sao như trong file cũ -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star-label');
        const ratingInputs = document.querySelectorAll('.rating-input');

        stars.forEach((star, index) => {
            star.addEventListener('mouseover', function () {
                highlightStars(index + 1);
            });

            star.addEventListener('mouseout', function () {
                const checkedStar = document.querySelector('.rating-input:checked');
                if (checkedStar) {
                    highlightStars(parseInt(checkedStar.value));
                } else {
                    resetStars();
                }
            });

            star.addEventListener('click', function () {
                updateSelectedStar(index + 1);
            });
        });

        function resetStars() {
            stars.forEach(star => {
                star.style.color = '#ddd';
            });
        }

        function highlightStars(count) {
            for (let i = 0; i < count; i++) {
                stars[i].style.color = 'gold';
            }
        }

        function updateSelectedStar(count) {
            resetStars();
            highlightStars(count);
            ratingInputs.forEach(input => {
                input.checked = (parseInt(input.value) === count);
            });
        }
    });
</script>
@endsection
