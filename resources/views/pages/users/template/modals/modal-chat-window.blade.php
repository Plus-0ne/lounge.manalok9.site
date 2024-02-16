<style>
    .cwindow-show {
        display: flex !important;
        flex-direction: column;
        position: fixed;
        z-index: 4;
    }

    .custom-Chatwindow {
        bottom: 30px;
        right: 0px;
        display: none;
        height: 450px;
        width: 100%;
        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
        -moz-box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
        -webkit-box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
        -ms-box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
        border-radius: 9px;
        background-color: #fff;
    }

    .message-title {
        padding: 1rem;
        background-color: #1e2530;
        color: #fff;
        border-radius: 9px 9px 0px 0px;
    }
    .message-body {
        height: 100%;
        max-height: 100%;
        overflow-x: hidden;
        overflow-y: auto;
    }
    .message-control {
        padding: 0.5rem 1rem 0.5rem 1rem;
        background-color: #1e2530;
        color: #fff;
        border-radius: 0px 0px 9px 9px;
        width: 100%;
    }
    .message-input-div {
        padding: 0.3rem 0.5rem 0.3rem 0.5rem;
        border-radius: 50px;
        background-color: #fff;
        height: 35px;

    }
    .message-input-div > input {
        height: 100%;
        width: 100%;
        background-color: transparent;
        border: none;
    }
    .message-input-div > input:focus {
        background-color: transparent;
        border: none;
        outline: none;
    }
    .message-send {
        width: auto;
    }
    .send-btn-icon {
        font-size: 1.8rem;
        text-align: center;
        margin-left: 3px;
    }
    .message-window-close {
        cursor: pointer;
    }
    .user-message {
        background-color: #1278bd;
        color: #fff;
        border-radius: 9px;
        word-break: break-word;
        width: auto;
    }
    .user-icon img {
        border-radius: 50px;

    }
    .message-to-name img {
        width: 30px;
        margin-right: 9px;
        border-radius: 50px;
    }
    /* Custom Emoji */
    .emojisection {
        position: relative;
    }
    .emojiContainer {
        display: none;
        position: absolute;
        left: 10px;
        bottom: 450px;

    }

    @media (min-width: 576px) {  }

    @media (min-width: 768px) {  }

    @media (min-width: 992px) {  }

    @media (min-width: 1200px) {
        .emojiContainer {
            display: none;
            position: absolute;
            left: -400px;
            top: -400px;

        }
        .custom-Chatwindow {

            bottom: 15px;
            right: 15px;
            display: none;

            height: 450px;
            width: 320px;

            box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
            -moz-box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
            -webkit-box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
            -ms-box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);

            border-radius: 9px;
            background-color: #fff;
        }
    }

    @media (min-width: 1400px) {  }

</style>
<div class="custom-Chatwindow">
    <div class="message-title d-flex justify-content-between align-items-center">
        <div class="message-to-name d-flex flex-row">
            <img id="userProfileImg" src="" alt="">
            <label id="userDataName">
                Romel Cubelo
            </label>
        </div>
        <div class="message-window-close">
            <i class="mdi mdi-close"></i>
        </div>
    </div>
    <div class="message-body d-flex flex-column-reverse p-3">

    </div>
    <div class="message-control d-flex flex-row align-items-center">
        <div class="emojisection">
            <div class="emojiContainer">

            </div>
            <button id="emojiBtn">
                <i class="mdi mdi-emoticon"></i>
            </button>
        </div>
        <div class="message-container w-100">
            <div class="message-input-div">
                <input id="message-text" class="textareaChat" type="text">
            </div>
        </div>
        <div class="message-send d-flex align-items-center justify-content-center text-center">
            <div class="send-btn-icon">
                <i class="mdi mdi-send"></i>
            </div>
        </div>
    </div>
</div>
