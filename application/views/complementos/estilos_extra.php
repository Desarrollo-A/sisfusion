
        <style type="text/css">        
            #modal_nuevas{
                z-index: 1041!important;
            }
            #modal_vc{
                z-index: 1041!important;
            }
            .beginDate, #beginDate{
                background-color: #eaeaea !important;
                border-radius: 27px 0 0 27px!important;
                background-image: initial!important;
                text-align: center!important;
            }
                
            .endDate, #endDate{
                background-color: #eaeaea !important;
                border-radius: 0!important;
                background-image: initial!important;
                text-align: center!important;
            }
            .btn-fab-mini {
                border-radius: 0 27px 27px 0 !important;
                background-color: #eaeaea !important;
                box-shadow: none !important;
                height: 45px !important;
            }
            .btn-fab-mini span {
                color: #929292;
            }

            $color-black: #000;
            $color-light-red: #ba3242;

            body{
            
            }

            .close-modal-button{
            position: absolute;
            right: 2%;
            top:    3%;
            z-index: 4;
            background-color: #fff;
            border-radius: 2em;
            height: 2em;
            width: 2em;
            box-shadow: 0 0 5px rgba(0,0,0,0.5);
            -webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);
            -moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);

            &:before{
                position: absolute;
                left: 50%;
                top: 50%;
                font-family: fontAwesome;
                content: "\f00d";
                color: $color-black;
                font-size: 1em;
                transform: translate(-50%, -50%);
            }
            &:hover:before{
                color: $color-light-red;
                -webkit-transition: background 350ms cubic-bezier(0.42, 0, 0.58, 1) 10ms, all 200ms cubic-bezier(0.42, 0, 0.58, 1) 10ms;
                -moz-transition: background 350ms cubic-bezier(0.42, 0, 0.58, 1) 10ms, all 200ms cubic-bezier(0.42, 0, 0.58, 1) 10ms;
                -o-transition: background 350ms cubic-bezier(0.42, 0, 0.58, 1) 10ms, all 200ms cubic-bezier(0.42, 0, 0.58, 1) 10ms;
                transition: background 350ms cubic-bezier(0.42, 0, 0.58, 1) 10ms, all 200ms cubic-bezier(0.42, 0, 0.58, 1) 10ms;
                -webkit-transform: translate(-55%, -48%) rotate(-0.25turn);
                transform: translate(-55%, -48%) rotate(-0.25turn); /*Had to bump it b/c the dimensions are not square*/
            }
            }
        </style>
       