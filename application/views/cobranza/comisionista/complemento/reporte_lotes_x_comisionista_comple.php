<style>
        .box_cash h6{
            line-height: 19px;
            font-size: 10px;
            font-weight: 100;
            color: #999;
        }
        .box_cash span{
            font-size: 25px;
            font-weight: 600;
            color: #4e4e4e;
        }
        .timelineR {
            position: relative;
            border-color: rgba(160, 175, 185, .15);
            padding: 0;
            margin: 0
        }

        .tl-item {
            border-radius: 3px;
            position: relative;
            display: -ms-flexbox;
            display: flex
        }

        .tl-item>* {
            padding: 10px
        }

        .tl-dot {
            position: relative;
            border-color: rgba(160, 175, 185, .15)
        }

        .tl-dot:after,
        .tl-dot:before {
            content: '';
            position: absolute;
            border-color: inherit;
            border-width: 2px;
            border-style: solid;
            border-radius: 50%;
            width: 10px;
            height: 10px;
            top: 15px;
            left: 50%;
            transform: translateX(-50%)
        }

        .tl-dot:after {
            width: 0;
            height: auto;
            top: 25px;
            bottom: -15px;
            border-right-width: 0;
            border-top-width: 0;
            border-bottom-width: 0;
            border-radius: 0
        }

        .tl-date {
            font-size: .85em;
            margin-top: 2px;
            min-width: 100px;
            max-width: 100%
        }

        .b-warning {
            border-color: #243D7C!important;
        }
        
        #rowTotales label{
            font-size: 12px;
        }

        #detailComisionistaBtn{
            background-color: #14386026; 
            color: #143860; 
            padding: 2px 10px 3px; 
            border-radius: 20px; 
            font-size: 13px; 
            font-weight: 700; 
            cursor: pointer;
        }
    </style>